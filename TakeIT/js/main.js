document.addEventListener("DOMContentLoaded", function () { 
	const mobileMenuAside = document.getElementById("mobile-menu-aside");
	const mobileMenuOpener = document.getElementById("btn-mobile-menu-opener");
	const mobileMenuCloser = document.getElementById("btn-mobile-menu-closer");

	mobileMenuOpener?.addEventListener("click", function () {
		mobileMenuAside?.classList.add("open");
	});

	mobileMenuCloser?.addEventListener("click", function () {
		mobileMenuAside?.classList.remove("open");
	});

	const mobileFilters = document.getElementById("mobile-filters");
	const mobileFiltersOpener = document.getElementById("btn-mobile-filters-opener");
	const mobileFiltersCloser = document.getElementById("btn-mobile-filters-closer");

	mobileFiltersOpener?.addEventListener("click", function () {
		mobileFilters?.classList.add("open");
	});

	mobileFiltersCloser?.addEventListener("click", function () {
		mobileFilters?.classList.remove("open");
	});
})