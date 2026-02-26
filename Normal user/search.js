(function () {
    function normalize(value) {
        return (value || "").toLowerCase().trim();
    }

    function getCurrentPage() {
        var parts = window.location.pathname.split("/");
        return parts[parts.length - 1] || "home.php";
    }

    function resolveHomeTarget(query) {
        var q = normalize(query);
        if (!q) return "home.php";

        var mappings = [
            { page: "movies.php", terms: ["movie", "movies", "film", "kung fu panda", "lagan", "bhabiji", "pass na pass"] },
            { page: "events.php", terms: ["event", "events", "concert", "comedy", "stand-up", "arijit", "zakir", "sunburn"] },
            { page: "Offers.php", terms: ["offer", "offers", "deal", "discount", "promo", "coupon", "cashback", "upi"] },
            { page: "My_Bookings.php", terms: ["booking", "bookings", "ticket", "tickets", "my booking", "my bookings"] }
        ];

        for (var i = 0; i < mappings.length; i++) {
            var map = mappings[i];
            for (var j = 0; j < map.terms.length; j++) {
                if (q.indexOf(map.terms[j]) !== -1) {
                    return map.page;
                }
            }
        }

        return "home.php";
    }

    window.handleSiteSearch = function (event) {
        event.preventDefault();
        var form = event.target;
        var input = form.querySelector("input[name='search']");
        var query = input ? input.value.trim() : "";
        if (!query) return false;

        var page = getCurrentPage().toLowerCase();
        var target = page === "home.php" ? resolveHomeTarget(query) : getCurrentPage();
        window.location.href = target + "?search=" + encodeURIComponent(query);
        return false;
    };

    function runPageSearch() {
        var params = new URLSearchParams(window.location.search);
        var query = params.get("search") || "";
        var normalizedQuery = normalize(query);

        var inputs = document.querySelectorAll("input[name='search']");
        inputs.forEach(function (input) {
            input.value = query;
        });

        var cards = document.querySelectorAll(".searchable-card");
        var noResults = document.getElementById("no-results");

        if (!cards.length) return;

        var visibleCount = 0;
        cards.forEach(function (card) {
            var haystack = normalize(card.getAttribute("data-search") || card.textContent);
            var match = !normalizedQuery || haystack.indexOf(normalizedQuery) !== -1;
            card.style.display = match ? "" : "none";
            if (match) visibleCount++;
        });

        if (noResults) {
            noResults.style.display = visibleCount === 0 ? "block" : "none";
            if (normalizedQuery) {
                noResults.textContent = "No results found for \"" + query + "\".";
            } else {
                noResults.textContent = "";
            }
        }
    }

    document.addEventListener("DOMContentLoaded", runPageSearch);
})();
