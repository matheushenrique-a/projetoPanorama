(function () {
  if (!location.hostname.includes('facebook.com')) return;

  function getTokenAndProceed(callback) {
    callback('openaccess');
  }

  function addDownloadButtonBelowVideo(video, index) {
    if (video.dataset.buttonAdded === 'true') return;

    const videoSrc = video.src || (video.querySelector('source')?.src);
    if (!videoSrc) return;

    const openButton = document.createElement('a');
    openButton.textContent = 'Download';
    openButton.href = "http://localhost/VSLs/ad-library/inspect-video/"
    //openButton.href = videoSrc;
    openButton.target = '_blank';
    openButton.style.display = 'inline-block';
    openButton.style.marginTop = '8px';
    openButton.style.marginBottom = '8px';
    openButton.style.padding = '10px 16px';
    openButton.style.backgroundColor = '#e44743';
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

      openButton.style.backgroundColor = '#e9ac12ff';
      openButton.textContent = 'Wait...';
      e.preventDefault();

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

        // Seleciona o elemento <video>
        //const videoElement = document.querySelector('video.x1lliihq.x5yr21d.xh8yej3');

        let target = video;

        //LID ID        
        for (let i = 0; i <= 10; i++) {target = target.parentElement;} // Sobe 11 níveis
        for (let i = 0; i <= 2; i++) {target = target.previousElementSibling;} // Sobe mais 3 elementos irmãos anteriores

        target = target.children[0]; 
        target = target.children[0]; 
        
        //lib
        let targetLib = target.children[1];
        targetLib = targetLib.children[0]; 
        targetLib = targetLib.children[0]; 
        targetLib = targetLib.children[0]; 
        const libraryId = targetLib.innerText.match(/\d+/g)?.join('') || '';
        //alert(libraryId);

        //DATA INFO
        let targetDate = target.children[2];
        targetDate = targetDate.children[0]; 
        const dateInfo = targetDate.innerText;
        //alert(dateInfo);

        //AD TEXT
        target = video;
        let adText = '';

        for (let i = 0; i <= 6; i++) {target = target.parentElement;} // Sobe 7 níveis
        target = target.previousElementSibling;
        
        if (target?.children[0]) {
          target = target?.children[0];
          target = target.children[0]; 
          target = target.children[0]; 
          target = target.children[0]; 
          target = target.children[0]; 
          adText = target.innerText?.trim() || '';
        }

        //ADVERTISE
        target = video;
        for (let i = 0; i <= 7; i++) {target = target.parentElement;} // Sobe 7 níveis
        target = target.previousElementSibling;
        target = target.children[0]; //img

        //as vezes a imagem é filha direta, as vezes é neta.
        let thumbnail = null;

        if (target.children[0].src) {
           target = target.children[0];
           thumbnail = target.src || '';
        } else {
           target = target.children[0];
           thumbnail = target.children[0].src || '';
        }
        
        //alert(thumbnail);

         target = target.nextElementSibling;

            target = target.children[0];
            target = target.children[0];
            target = target.children[0];
            target = target.children[0];

        const advertiser = target.innerText?.trim() || '';
        //alert(advertiser);
       
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
            //alert('id:' + response.guid);
            //openButton.href = "http://localhost/VSLs/ad-library/inspect-video/" + response.guid;
            //openButton.click();
            openButton.style.backgroundColor = '#1da913ff';
            openButton.textContent = 'Done';

            window.open("http://localhost/VSLs/ad-library/inspect-video/" + response.guid, '_blank'); // abre em nova aba
          } else {
            openButton.textContent = 'Error';
            //alert('Erro ao salvar Ads.');
          }
        });
      });

      //e.preventDefault();
    });

    const wrapper = document.createElement('div');
    wrapper.style.textAlign = 'center';
    wrapper.style.marginTop = '8px';
    wrapper.appendChild(openButton);

    video.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.insertAdjacentElement('afterend', wrapper);
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