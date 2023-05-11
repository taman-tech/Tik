const form = document.querySelector("form");
const output = document.querySelector("#output");

form.addEventListener("submit", (event) => {
  event.preventDefault();

  const url = form.elements.url.value;
  if (!url) {
    output.innerHTML = "<p>Please enter a URL.</p>";
    return;
  }

  const videoId = getVideoId(url);
  if (!videoId) {
    output.innerHTML = "<p>Invalid URL.</p>";
    return;
  }

  const downloadUrl = getDownloadUrl(videoId);
  if (!downloadUrl) {
    output.innerHTML = "<p>Unable to get download URL.</p>";
    return;
  }

  output.innerHTML = `
    <p>Right click on the download button below and select "Save link as..." to download the video.</p>
    <a href="${downloadUrl}" download>Download Video</a>
  `;
});

function getVideoId(url) {
  const match = url.match(/\/video\/(\d+)/);
  if (match) {
    return match[1];
  } else {
    return null;
  }
}

async function getDownloadUrl(videoId) {
  const response = await fetch(`https://www.tiktok.com/node/share/video/${videoId}`);
  const data = await response.json();
  const video = data.collector[0];
  if (video) {
    const downloadUrl = video.downloadAddr.replace(/watermark=1/, "watermark=0");
    return downloadUrl;
  } else {
    return null;
  }
}
