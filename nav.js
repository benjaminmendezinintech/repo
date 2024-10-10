const container = document.querySelector(".container");
const linkItems = document.querySelectorAll(".link-item");
const darkMode = document.querySelector(".dark-mode");
const logo = document.querySelector(".logo svg");

//Container Hover
container.addEventListener("mouseenter", () => {
  container.classList.add("active");
});

//Container Hover Leave
container.addEventListener("mouseleave", () => {
  container.classList.remove("active");
});

//Link-items Clicked
for (let i = 0; i < linkItems.length; i++) {
  if (!linkItems[i].classList.contains("dark-mode")) {
    linkItems[i].addEventListener("click", (e) => {
      linkItems.forEach((linkItem) => {
        linkItem.classList.remove("active");
      });
      linkItems[i].classList.add("active");
    });
  }
}

// Dark Mode Functionality
darkMode.addEventListener("click", function () {
  if (document.body.classList.contains("dark-mode")) {
    darkMode.querySelector("span").textContent = "dark mode";
    darkMode.querySelector("ion-icon").setAttribute("name", "moon-outline");

    logo.style.fill = "#363b46";
  } else {
    darkMode.querySelector("span").textContent = "light mode";
    darkMode.querySelector("ion-icon").setAttribute("name", "sunny-outline");
    logo.style.fill = "#fff";
  }
  document.body.classList.toggle("dark-mode");
});



document.addEventListener("DOMContentLoaded", function() {
  const ctx = document.getElementById('ahorro-chart').getContext('2d');
  
  // Datos ficticios
  const meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
  const ahorrosMensuales = [500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 1600];

  // Crear gráfico
  const myChart = new Chart(ctx, {
      type: 'line', // Tipo de gráfico
      data: {
          labels: meses, // Eje X
          datasets: [{
              label: 'Ahorro por Mes',
              data: ahorrosMensuales, // Datos de la gráfica
              borderColor: 'rgba(34, 142, 230, 1)',
              backgroundColor: 'rgba(34, 142, 230, 0.2)',
              fill: true,
          }]
      },
      options: {
          responsive: true,
          scales: {
              y: {
                  beginAtZero: true,
                  title: {
                      display: true,
                      text: 'Monto en $'
                  }
              },
              x: {
                  title: {
                      display: true,
                      text: 'Meses'
                  }
              }
          }
      }
  });
});