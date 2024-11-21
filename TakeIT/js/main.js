document.addEventListener("DOMContentLoaded", function () { 
	const mobileMenuAside = document.getElementById("mobile-menu-aside");
	const mobileMenuOpener = document.getElementById("btn-mobile-menu-opener");
	const mobileMenuCloser = document.getElementById("btn-mobile-menu-closer");

	mobileMenuOpener.addEventListener("click", function () {
		mobileMenuAside.classList.add("open");
	});

	mobileMenuCloser.addEventListener("click", function () {
		mobileMenuAside.classList.remove("open");
	});
})