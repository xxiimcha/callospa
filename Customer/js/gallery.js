const tabsGallery = document.querySelectorAll(".btn-gallery");
const tabsContainerGallery = document.querySelector(".gallery-tab-container");
const tabsContentGallery = document.querySelectorAll(".gallery-content");

tabsContainerGallery.addEventListener("click", (e) => {
  const clicked = e.target.closest(".btn-gallery");

  if (!clicked) return;

  // Remove Active Classes
  tabsGallery.forEach((tab) => tab.classList.remove("btn-gallery-active"));
  tabsContentGallery.forEach((content) =>
    content.classList.remove("gallery-content-active")
  );

  // Add Active Classes
  clicked.classList.add("btn-gallery-active");
  document
    .querySelector(`.gallery-content--${clicked.dataset.tab}`)
    .classList.add("gallery-content-active");
});