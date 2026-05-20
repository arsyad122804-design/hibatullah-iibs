
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab
function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
      document.getElementById("nextBtn").innerHTML = "Submit";
      document.getElementById("nextBtn").setAttribute('type', 'submit')
  } else {
    document.getElementById("nextBtn").setAttribute('type', 'button')
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

$(".form-control").on('keyup change ',function() {
    $(".form-control").removeClass("invalid")
    $(".col-form-label").removeClass("invallable")
})

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("form").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
 
  var form = $("form");
  form.validate({
    errorElement: 'span',
    errorClass: 'help-block',
    highlight: function (element, errorClass, validClass) {
      $(element).closest('.form-group').addClass("has-error");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).closest('.form-group').removeClass("has-error");
    },
  })
  if (form.valid() === true) {
    if ($('#account_information').is(":visible")) {
        current_fs = $('#account_information');
        next_fs = $('#company_information');
    } else if ($('#company_information').is(":visible")) {
        current_fs = $('#company_information');
        next_fs = $('#personal_information');
    }

    next_fs.show();
    current_fs.hide();
}
}


function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}