document.getElementById("filterForm").addEventListener("submit", function (e) {
    e.preventDefault();
    console.log('Filter submitted');
    const statusFilter = document.getElementById("status").value.trim().toLowerCase();
    const dateFrom = document.getElementById("date_from").value;
    const dateTo = document.getElementById("date_to").value;

    const rows = document.querySelectorAll("#ordersTable tbody tr");
    let anyVisible = false; 

    rows.forEach(function (row) {
        const rowStatus = row.dataset.status;
        const rowDate = row.dataset.date;

        let showRow = true;

        if (statusFilter && rowStatus !== statusFilter) {
            showRow = false;
        }

        if (dateFrom && rowDate < dateFrom) {
            showRow = false;
        }

        if (dateTo && rowDate > dateTo) {
            showRow = false;
        }

        row.style.display = showRow ? "" : "none";

        // Check if any row is visible
        if (showRow) {
            anyVisible = true;
        }
    });

    const noResultsMsg = document.getElementById("noResultsMessage");
    console.log('Any visible rows:', anyVisible);
    if (noResultsMsg) {
        noResultsMsg.style.display = anyVisible ? "none" : "block";
    }
});
