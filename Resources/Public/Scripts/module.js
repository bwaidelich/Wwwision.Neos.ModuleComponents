window.addEventListener("DOMContentLoaded", () => {

	function toggleClasses(element) {
		const targetElement = document.getElementById(element.dataset.toggle);
		if (!targetElement) {
			console.error("Target element " + element.dataset.target + " not found");
		}
		const hidden = targetElement.classList.toggle("neos-hide");
		const iconElement = element.querySelector('i.fas');
		if (iconElement && element.dataset.icontoggled) {
			if (hidden) {
				iconElement.classList.replace(element.dataset.icontoggled, element.dataset.icon);
			} else {
				iconElement.classList.replace(element.dataset.icon, element.dataset.icontoggled);
			}
		}
	}

	/**
	 * @param date {Date}
	 * @param locale {string | undefined}
	 * @param options {object | undefined}
	 * @returns {string}
	 */
	function getRelativeTimeString(date, locale, options) {
		const deltaSeconds = Math.round((date.getTime() - Date.now()) / 1000);

		// Array reprsenting one minute, hour, day, week, month, etc in seconds
		const cutoffs = [60, 3600, 86400, 86400 * 7, 86400 * 30, 86400 * 365, Infinity];

		// Array equivalent to the above but in the string representation of the units
		const units = ["second", "minute", "hour", "day", "week", "month", "year"];

		// Grab the ideal cutoff unit
		const unitIndex = cutoffs.findIndex(cutoff => cutoff > Math.abs(deltaSeconds));

		// Get the divisor to divide from the seconds. E.g. if our unit is "day" our divisor
		// is one day in seconds, so we can divide our seconds by this to get the # of days
		const divisor = unitIndex ? cutoffs[unitIndex - 1] : 1;

		// Intl.RelativeTimeFormat do its magic
		const rtf = new Intl.RelativeTimeFormat(locale, options);
		return rtf.format(Math.floor(deltaSeconds / divisor), units[unitIndex]);
	}

	document.addEventListener("click", function (event) {
		let toggleElement;
		if (toggleElement = event.target.closest('a[data-toggle]')) {
			event.preventDefault();
			toggleClasses(toggleElement);
		}
	})

	document.querySelectorAll('time[datetime][data-relativetime]').forEach((element) => {
		const locale = element.dataset.locale || undefined;
		const options = element.dataset.options ? JSON.parse(element.dataset.options) : undefined;
		element.innerText = getRelativeTimeString(new Date(element.getAttribute('datetime')), locale, options);
	});
});
