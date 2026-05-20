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
	errorPlacement: function errorPlacement(error, element) {
		element.after(error);
	},
});

$(".tab-wizard").steps({
	headerTag: "h5",
	bodyTag: "section",
	autoFocus: true,
	transitionEffect: "fade",
	enableAllSteps: true,
	titleTemplate: '<span class="step">#index#</span> #title#',
	onStepChanging: function (event, currentIndex, newIndex) {
		form.validate().settings.ignore = ":disabled,:hidden";
		return form.valid();
	},
	onFinishing: function (event, currentIndex) {
		form.validate().settings.ignore = ":disabled";
		return form.valid();
	},
	onFinished: function (event, currentIndex) {
		form.submit();
	}
});

var elems = Array.prototype.slice.call(document.querySelectorAll('.switch-btn'));

$('.switch-btn').each(function () {
	new Switchery($(this)[0], $(this).data());
});
