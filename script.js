// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
        
        // Close menu when a link is clicked
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', function() {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });
    }
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInside = event.target.closest('.navbar');
        if (!isClickInside && navLinks && navLinks.classList.contains('active')) {
            hamburger.classList.remove('active');
            navLinks.classList.remove('active');
        }
    });
});

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;
    
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#f56565';
            isValid = false;
        } else {
            input.style.borderColor = '#e2e8f0';
        }
    });
    
    return isValid;
}

// Password Validation
function validatePassword(password, confirmPassword) {
    if (password !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas');
        return false;
    }
    if (password.length < 6) {
        alert('Le mot de passe doit contenir au moins 6 caractères');
        return false;
    }
    return true;
}

// Delete Confirmation
function confirmDelete(itemName = 'cette dépense') {
    return confirm(`Êtes-vous sûr de vouloir supprimer ${itemName}?`);
}

// Format Currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR'
    }).format(amount);
}

// Filter Form Submit
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let hasErrors = false;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                hasErrors = true;
            } else {
                field.classList.remove('error');
            }
        });
        
        if (hasErrors) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires');
        }
    });
});

// Input Focus Styling
document.querySelectorAll('input, textarea, select').forEach(input => {
    input.addEventListener('focus', function() {
        this.style.borderColor = '#667eea';
    });
    
    input.addEventListener('blur', function() {
        if (!this.value && this.hasAttribute('required')) {
            this.style.borderColor = '#f56565';
        } else {
            this.style.borderColor = '#e2e8f0';
        }
    });
});

// Modal Functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
    }
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
    }
});

// Number Input Formatting
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
});

// Table Row Highlighting
document.querySelectorAll('tbody tr').forEach(row => {
    row.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#ebf8ff';
    });
    
    row.addEventListener('mouseleave', function() {
        this.style.backgroundColor = 'transparent';
    });
});

// Auto-hide alerts
document.querySelectorAll('.alert').forEach(alert => {
    if (alert.classList.contains('alert-success')) {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    }
});

// Responsive Navigation Toggle
function toggleNavigation() {
    const navLinks = document.querySelector('.nav-links');
    if (navLinks) {
        navLinks.classList.toggle('active');
    }
}

// Export to CSV
function exportTableToCSV(tableId, filename = 'depenses.csv') {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    let csv = [];
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const csvCols = [];
        cols.forEach(col => {
            csvCols.push('"' + col.innerText.replace(/"/g, '""') + '"');
        });
        csv.push(csvCols.join(','));
    });
    
    downloadCSV(csv.join('\n'), filename);
}

function downloadCSV(csv, filename) {
    const csvFile = new Blob([csv], {type: 'text/csv'});
    const downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(csvFile);
    downloadLink.download = filename;
    downloadLink.click();
}
