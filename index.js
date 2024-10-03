document.addEventListener("DOMContentLoaded", function () {
  const monthNameElement = document.getElementById("monthName");
  const calendarDaysElement = document.getElementById("calendarDays");
  let currentYear = new Date().getFullYear();
  let currentMonth = new Date().getMonth();
  const weekDays = ["Seg", "Ter", "Qua", "Qui", "Sex", "Sab", "Dom"];

  updateCalendar();

  

  document.getElementById("prevMonthBtn").addEventListener("click", function () {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    updateCalendar();
  });

  document.getElementById("todayBtn").addEventListener("click", function () {
    currentYear = new Date().getFullYear();
    currentMonth = new Date().getMonth();
    updateCalendar();
  });

  calendarDaysElement.addEventListener("dblclick", function(event) {
    if (event.target.classList.contains("date")) {
      document.getElementById("agendarSection").style.display = "block";
      document.getElementById("agendarSection").scrollIntoView;
    }
    
  });


  calendarDaysElement.addEventListener("click", function(event) {
    if (event.target.classList.contains("date")) {
      // Pega o texto do dia clicado
      const dia = event.target.textContent;
      // Pega o texto do mês
      const mes = monthNameElement.textContent.split(" ")[0]; // Pega apenas o nome do mês
      const ano = currentYear;

      

      // Formata a data no formato DD/MM/AAAA
      const meses = {
        "Janeiro": "01",
        "Fevereiro": "02",
        "Março": "03",
        "Abril": "04",
        "Maio": "05",
        "Junho": "06",
        "Julho": "07",
        "Agosto": "08",
        "Setembro": "09",
        "Outubro": "10",
        "Novembro": "11",
        "Dezembro": "12"
      };
      const dataFormatada = `${dia}/${meses[mes]}/${ano}`;

      const inputData = document.getElementById("inputData");
      inputData.value = dataFormatada;
    }
  });



  document.getElementById("nextMonthBtn").addEventListener("click", function () {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    updateCalendar();
  });

  function updateCalendar() {
    const daysInMonth = getDaysInMonth(currentYear, currentMonth);
    const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay() || 7;
    const daysInPrevMonth = getDaysInMonth(currentYear, currentMonth - 1);

    const monthName = new Date(currentYear, currentMonth).toLocaleString("default", {
      month: "long",
      year: "numeric",
    });
    monthNameElement.innerHTML = monthName.charAt(0).toUpperCase() + monthName.slice(1);
    calendarDaysElement.innerHTML = weekDays.map(day => `<span class="day">${day}</span>`).join("");

    for (let i = firstDayOfMonth - 1; i > 0; i--) {
      const day = daysInPrevMonth - i + 1;
      calendarDaysElement.innerHTML += `<button class="date faded">${day}</button>`;
    }

    for (let day = 1; day <= daysInMonth; day++) {
      const isToday = isCurrentDay(day, currentMonth, currentYear) ? "current-day" : "";
      calendarDaysElement.innerHTML += `<button class="date ${isToday}">${day}</button>`;
    }
    const remainingDays = 7 - ((daysInMonth + firstDayOfMonth - 1) % 7);
    for (let i = 1; i < remainingDays && remainingDays < 7; i++) {
      calendarDaysElement.innerHTML += `<button class="date faded">${i}</button>`;
    }
  }

  function getDaysInMonth(year, month) {
    return new Date(year, month + 1, 0).getDate();
  }

  function isCurrentDay(day, month, year) {
    const today = new Date();
    return (
      day === today.getDate() &&
      month === today.getMonth() &&
      year === today.getFullYear()
    );
  }


});


