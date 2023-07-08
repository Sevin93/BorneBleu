$(document).ready(function () {
  var today =  new Date();
  var maxDate = new Date(today.getFullYear(), today.getMonth() + 3, today.getDate());

  flatpickr("#datepicker", {
    dateFormat: "d/m/Y",
    minDate: "today",
    maxDate: maxDate,
    disable: [
      function (date) {
        return (date.getDay() === 0 || date.getDay() === 6);
      }
    ],
    onChange: function (selectedDates, dateStr, instance) { // Remplir les créneaux horaires une fois qu'une date est sélectionnée
      var nbHeure = $("#select-heure").val();
      var datepicker = $("#datepicker").val();

      $.ajax({
        url: '/api/planning',
        type: 'GET',
        dataType: 'json',
        data: {
          nbHeure: nbHeure,
          selectedDate: datepicker
        },
        success: function (data) {
          $('#timepicker').empty();
          for (let i = 0; i <= data.length; i++) {
            $('#timepicker').append(new Option(data[i], data[i]));
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error(textStatus, errorThrown);
        }
      });
    }
  });

  $("#planning-form").submit(function (e) {
    e.preventDefault();
    var nbHeure = $("#select-heure").val();
    var datepicker = $("#datepicker").val();
    var creneau = $("#timepicker").val();


    $.ajax({
      url: '/api/planning/new',
      type: 'POST',
      dataType: 'json',
      data: JSON.stringify({ nbHeure: nbHeure, selectedDate: datepicker, creneau: creneau }),
      success: function (data) {
        //location.reload();
       // window.location.href = '/planning/reservation/user';
        window.location.href = '/planning/reservation/email/'+ nbHeure+"/"+datepicker+"/"+creneau;

      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error(textStatus, errorThrown);
      }
    });
  });
  let showless=document.getElementById("showless");
  let showmore=document.getElementById("showmore");
  showmore.addEventListener("click", ()=>{
    console.log("click");
    document.querySelectorAll(".to-hide").forEach((el)=>{
      el.classList.remove("d-none");
      showmore.classList.add("d-none");
      showless.classList.remove("d-none");
    })

  })

  showless.addEventListener("click", ()=>{
    console.log("click");
    document.querySelectorAll(".to-hide").forEach((el)=>{
      el.classList.add("d-none");
      showless.classList.add("d-none");
      showmore.classList.remove("d-none");

    })
  })
});