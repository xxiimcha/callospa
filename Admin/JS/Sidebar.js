const toggleButton = document.getElementById('toggle-btn');
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content'); // Select the content section

function toggleSidebar() {
  sidebar.classList.toggle('close');
  toggleButton.classList.toggle('rotate');
  closeAllSubMenus();

  if (sidebar.classList.contains('close')) {
    content.style.width = 'calc(100% - 60px)'; 
    content.style.left = '60px'; 
  } else {
    content.style.width = 'calc(100% - 280px)'; 
    content.style.left = '280px'; 
  }
}

function toggleSubMenu(button){

  if(!button.nextElementSibling.classList.contains('show')){
    closeAllSubMenus()
  }

  button.nextElementSibling.classList.toggle('show')
  button.classList.toggle('rotate')

  if(sidebar.classList.contains('close')){
    sidebar.classList.toggle('close')
    toggleButton.classList.toggle('rotate')
  }
}

function closeAllSubMenus(){
  Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
    ul.classList.remove('show')
    ul.previousElementSibling.classList.remove('rotate')
  })
}


function toggleActiveState(button) {
  
  const allButtons = document.querySelectorAll('#sidebar a, #sidebar .dropdown-btn');
  allButtons.forEach(btn => btn.classList.remove('active'));

  button.classList.add('active');

  const buttonHref = button.getAttribute('href') || button.textContent.trim();
  localStorage.setItem('activeButton', buttonHref); 
}

document.querySelectorAll('#sidebar a, #sidebar .dropdown-btn').forEach(button => {
  button.addEventListener('click', function() {
    toggleActiveState(this);
  });
});


function restoreActiveState() {
  const savedActiveButton = localStorage.getItem('activeButton');
  
  if (savedActiveButton) {
    
    document.querySelectorAll('#sidebar a, #sidebar .dropdown-btn').forEach(button => {
      const buttonHref = button.getAttribute('href') || button.textContent.trim();
      if (buttonHref === savedActiveButton) {
        button.classList.add('active'); 
      }
    });
  }
}


document.addEventListener('DOMContentLoaded', restoreActiveState);
