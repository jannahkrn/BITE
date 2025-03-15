document.querySelectorAll('.offerings-grid .card1, .offerings-grid .card2, .offerings-grid .card3, .offerings-grid .card4, .offerings-grid .card5, .offerings-grid .card6').forEach(card => {
    card.addEventListener('click', () => {
        const category = card.getAttribute('data-category'); 
        window.location.href = 'category.html?category=' + encodeURIComponent(category); 
    });
});

document.querySelectorAll('nav a').forEach(anchor => {
    anchor.addEventListener('click', e => {
        e.preventDefault();
        const target = anchor.getAttribute('href');
        const targetElement = document.querySelector(target);
        if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth' });
        } else {
            switch (target) {
                case "#offerings":
                    window.location.href = 'index.html#offerings';
                    break;
                case "#intro":
                    window.location.href = 'index.html#intro';
                    break;
                case "#intro2":
                    window.location.href = 'index.html#intro2';
                    break;
                case "#hero":
                    window.location.href = 'index.html'; 
                    break;
                default:
                    window.location.href = 'index.html';
            }
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
        category.addEventListener("click", () => {
            const categoryName = category.textContent; 
            console.log("Selected category:", categoryName); 
            loadProducts(categoryName); 

            const targetElement = document.querySelector('aside ul li a[href="#' + categoryName.toLowerCase() + '"]');
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' }); 
            }

        });
    });

    document.querySelectorAll('aside ul li').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('aside ul li').forEach(li => li.classList.remove('active'));
            this.classList.add('active');
        });
    });

    const addProductButton = document.querySelector('#add-product-button');
    if (addProductButton) {
        addProductButton.addEventListener('click', () => window.location.href = 'addproduct.html');
    }
