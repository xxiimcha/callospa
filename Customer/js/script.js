"use strict";

// Navigation
const header = document.querySelector(".header");
const btnNav = document.querySelector(".nav-btn");

// Tabs
const tabs = document.querySelectorAll(".btn-package");
const tabsContainer = document.querySelector(".packages-tab-container");
const tabsContent = document.querySelectorAll(".packages-content");

btnNav.addEventListener("click", () => {
  header.classList.toggle("active");
}); 

tabsContainer.addEventListener("click", (e) => {
  const clicked = e.target.closest(".btn-package");

  if (!clicked) return;

  // Remove Active Classes
  tabs.forEach((tab) => tab.classList.remove("btn-package-active"));
  tabsContent.forEach((content) =>
    content.classList.remove("packages-content-active")
  );

  // Add Active Classes
  clicked.classList.add("btn-package-active");
  document
    .querySelector(`.packages-content--${clicked.dataset.tab}`)
    .classList.add("packages-content-active");
});