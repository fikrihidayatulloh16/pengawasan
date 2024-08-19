let currentPage = 1;
let rowsPerPage = 15;
let sortDirection = {};

function updateTable() {
    let selectedValue = document.getElementById('row_count').value;
    let table = document.getElementById('table-body');
    let totalRows = table.rows.length;

    if (selectedValue === "all") {
        rowsPerPage = totalRows; // Show all rows
    } else {
        rowsPerPage = parseInt(selectedValue);
    }

    displayTable(currentPage);
    generatePagination();
}

function displayTable(page) {
    let table = document.getElementById('table-body');
    let rows = table.rows;
    let start = (page - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    
    for (let i = 0; i < rows.length; i++) {
        rows[i].style.display = (i >= start && i < end) ? '' : 'none';
    }
}

function generatePagination() {
    let table = document.getElementById('table-body');
    let rows = table.rows.length;
    let pages = Math.ceil(rows / rowsPerPage);
    let pagination = document.getElementById('pagination');
    
    pagination.innerHTML = '';
    
    for (let i = 1; i <= pages; i++) {
        let li = document.createElement('li');
        li.className = 'page-item' + (i === currentPage ? ' active' : '');
        li.innerHTML = `<a class="page-link" href="#" onclick="gotoPage(${i})">${i}</a>`;
        pagination.appendChild(li);
    }
}

function gotoPage(page) {
    currentPage = page;
    displayTable(page);
    generatePagination();
}

function sortTable(columnIndex) {
    let table = document.getElementById("myTable");
    let rows = Array.from(table.querySelector('tbody').rows); // Exclude header row

    // Check current sort direction and toggle it
    if (!sortDirection[columnIndex]) {
        sortDirection[columnIndex] = 'asc'; // Set default sort direction to ascending
    } else if (sortDirection[columnIndex] === 'asc') {
        sortDirection[columnIndex] = 'desc'; // Toggle to descending
    } else {
        sortDirection[columnIndex] = 'asc'; // Toggle back to ascending
    }

    let direction = sortDirection[columnIndex];

    let sortedRows = rows.sort((a, b) => {
        let cellA = a.cells[columnIndex].innerText;
        let cellB = b.cells[columnIndex].innerText;
        
        if (direction === 'asc') {
            return cellA.localeCompare(cellB);
        } else {
            return cellB.localeCompare(cellA);
        }
    });

    // Append sorted rows back to the table
    sortedRows.forEach(row => table.querySelector('tbody').appendChild(row));

    // Clear all icons first
    document.querySelectorAll('.sort-icon').forEach(icon => {
        icon.classList.remove('fa-sort-up', 'fa-sort-down');
        icon.classList.add('fa-sort');
    });

    // Update icon based on sorting direction
    let icon = document.getElementById(`icon${columnIndex}`);
    if (direction === 'asc') {
        icon.classList.remove('fa-sort', 'fa-sort-down');
        icon.classList.add('fa-sort-up');
    } else {
        icon.classList.remove('fa-sort', 'fa-sort-up');
        icon.classList.add('fa-sort-down');
    }
}

// Initial table setup
document.addEventListener('DOMContentLoaded', function() {
    displayTable(currentPage);
    generatePagination();
});
