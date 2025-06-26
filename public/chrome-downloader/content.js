(function () {
  if (!location.hostname.includes('facebook.com')) return;

  function addDownloadButtonBelowVideo(video, index) {
    if (video.dataset.buttonAdded === 'true') return;

    const videoSrc = video.src || (video.querySelector('source')?.src);
    if (!videoSrc) return;

    const openButton = document.createElement('a');
    openButton.textContent = 'Download';
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