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

function toggleContent(button) {
    const hiddenContent = button.previousElementSibling;
    if (hiddenContent.style.display === "none" || hiddenContent.style.display === "") {
        hiddenContent.style.display = "inline";
        button.textContent = "Mostra meno";
    } else {
        hiddenContent.style.display = "none";
        button.textContent = "Leggi tutto";
    }
}

function segnaComeLetta(section){
	section.setAttribute('notifica-letta',true); 
}
