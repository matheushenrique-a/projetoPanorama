(function () {
  if (!location.hostname.includes('facebook.com')) return;

  function getTokenAndProceed(callback) {
    chrome.storage.local.get(['userToken'], (result) => {
      if (result.userToken) {
        callback(result.userToken);
      } else {
        const input = prompt('Acesso Restrito - Digite Token do Assinante:');
        if (!input) return;

        chrome.runtime.sendMessage({
          action: "validateToken",
          payload: { token: input }
        }, (response) => {
          if (response?.valid) {
            chrome.storage.local.set({ userToken: input }, () => {
              callback(input);
            });
          } else {
            alert("Token inválido - Acesso Restrito Nesse Momento.");
          }
        });
      }
    });
  }

  function addDownloadButtonBelowVideo(video, index) {
    if (video.dataset.buttonAdded === 'true') return;

    const videoSrc = video.src || (video.querySelector('source')?.src);
    if (!videoSrc) return;

    const openButton = document.createElement('a');
    openButton.textContent = 'Save Ad';
    openButton.href = videoSrc;
    openButton.target = '_blank';
    openButton.style.display = 'inline-block';
    openButton.style.marginTop = '8px';
    openButton.style.padding = '10px 16px';
    openButton.style.backgroundColor = '#007bff';
    openButton.style.color = '#fff';
    openButton.style.borderRadius = '4px';
    openButton.style.textDecoration = 'none';
    openButton.style.fontWeight = 'bold';
    openButton.style.fontFamily = 'Arial, sans-serif';
    openButton.style.zIndex = '9999';
    openButton.style.position = 'relative';

    openButton.addEventListener('click', function (e) {
      // const proceed = confirm('Deseja abrir o vídeo em uma nova aba?');
      // if (!proceed) {
      //   e.preventDefault();
      //   return;
      // }

      getTokenAndProceed((userToken) => {
        // Sobe até o ancestral direto que tem múltiplos dados
        let container = video.closest('div.card-shadow');

        // Se não encontrar pelo closest, tenta subir manualmente alguns níveis
        if (!container) {
          container = video.parentElement?.closest('div[class*="x1plvlek"]');
        }

        if (!container) {
          console.warn('⚠️ Contêiner de anúncio não encontrado para este vídeo:', video);
        }

        const advertiser = container?.querySelector('a[target="_blank"] span')?.textContent?.trim() || '';
        const adText = container?.querySelector('._4ik4._4ik5 > div[style*="white-space"]')?.innerText?.trim() || '';
        const libraryId = Array.from(container?.querySelectorAll('span') || [])
          .find(el => el.textContent?.includes('Library ID:'))?.textContent?.trim() || '';
        const dateInfo = Array.from(container?.querySelectorAll('span') || [])
          .find(el => el.textContent?.includes('Started running on'))?.textContent?.trim() || '';
        //const thumbnail = container?.querySelector('img[src*="scontent"][alt=""]')?.src || '';
        const thumbnail = container.querySelector('img[src*="scontent"]')?.src || '';

        chrome.runtime.sendMessage({
          action: "saveAd",
          payload: {
            user: userToken,
            url: videoSrc,
            advertiser,
            adText,
            libraryId,
            dateInfo,
            thumbnail
          }
        }, (response) => {
          if (response?.success) {
            openButton.textContent = 'Saved OK!';
          } else {
            alert('Erro ao salvar Ads.');
          }
        });
      });

      e.preventDefault();
    });

    const wrapper = document.createElement('div');
    wrapper.style.textAlign = 'center';
    wrapper.style.marginTop = '8px';
    wrapper.appendChild(openButton);

    video.insertAdjacentElement('afterend', wrapper);
    video.dataset.buttonAdded = 'true';
  }

  function scanAndInsertButtons() {
    const videos = document.querySelectorAll('video');
    videos.forEach((video, index) => {
      addDownloadButtonBelowVideo(video, index);
    });
  }

  scanAndInsertButtons();

  const observer = new MutationObserver(() => {
    scanAndInsertButtons();
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
})();