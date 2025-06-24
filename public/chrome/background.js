chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
  if (message.action === "saveAd") {
    const { user, url, advertiser, adText, libraryId, dateInfo, thumbnail } = message.payload;

    //fetch("http://localhost/InsightSuite/public/ads-savead", {
    fetch("https://insightsuite.pravoce.io/ads-savead", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        user,
        url,
        advertiser,
        adText,
        libraryId,
        dateInfo,
        thumbnail
      })
    })
      .then(response => response.json())
      .then(data => {
        sendResponse({ success: true });
      })
      .catch(error => {
        console.error("Erro ao salvar ad:", error);
        sendResponse({ success: false });
      });

    return true; // manter canal de resposta assíncrona aberto
  }

  if (message.action === "validateToken") {
    const { token } = message.payload;

    //fetch("http://localhost/InsightSuite/public/ads-validatetoken", {
    fetch("https://insightsuite.pravoce.io/ads-validatetoken", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ token })
    })
      .then(response => response.json())
      .then(data => {
        sendResponse({ valid: data?.valid === true });
      })
      .catch(error => {
        console.error("Erro ao validar token:", error);
        sendResponse({ valid: false });
      });

    return true;
  }
});