require('bootstrap-datepicker/js/bootstrap-datepicker');

import Swal from "sweetalert2";
require('bootstrap');

$(document).ready(function() {
  $('.js-datepicker').datepicker({
    format: 'dd/mm/yyyy'
  });
  $('.datetimepicker').datetimepicker({
    format: 'dd/mm/yyyy HH:mm',
    pick12HourFormat: false
  });


  $('.add-another-collection-widget').click(function (e) {
    var list = $($(this).attr('data-list-selector'));

    var counter = $('#company-address-collection').children().length;

    var newWidget = list.attr('data-prototype');

    if(counter <= 2) {
      console.log(newWidget);
      newWidget = newWidget.replace(/__name__/g, counter);

      counter++;

      $('#company-address-collection').attr('data-widget-counter', counter);

      var newElem = $($.parseHTML(newWidget));
      newElem.find('i').css('display', 'inline');
      newElem.appendTo(list);
    } else {
      Swal.fire({
        title: 'Attention !',
        text: 'Le nombre d\'adresses maximum est limité à 3.',
        icon: 'error',
        confirmButtonText: 'Continuer'
      })
    }
  });
  $('.collapse').collapse('hide');
});

(function () {
  'use strict'
  var forms = document.querySelectorAll('.form-content form')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
