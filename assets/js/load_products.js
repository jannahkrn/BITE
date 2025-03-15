function loadProducts() {
    const urlParams = new URLSearchParams(window.location.search);
    var myParam = urlParams.get('category');
    var id = urlParams.get('id');
    if (!myParam) {
        myParam = 'all';
    }

    if (!id) {
        fetch('./fungsi/fetch_products.php?category='+ encodeURIComponent(myParam))
        .then(response => response.text())
        .then(data => {
            document.getElementById('product-list').innerHTML = data; // Populate product list
        })
        .catch(error => console.error('Error fetching products:', error));
    }else{
        console.log(id);
        fetch('./fungsi/fetch_products.php?id=' + encodeURIComponent(id))
        .then(response => response.json()) 
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
            } else {
                document.getElementById('name').value = data.name;
                document.getElementById('creator').value = data.creator;
                document.getElementById('price').value = data.price;
                document.getElementById('category_select').value = data.category;
                document.getElementById('link').value = data.link;
                document.getElementById('productid').value = data.id;
                if (data.photo) {
                     document.getElementById('display_foto').style.display = "block";
                     document.getElementById('display_foto').src = "./uploads/"+data.photo;
                }else{
                    document.getElementById('display_foto').style.display = "none";
                    document.getElementById('display_foto').src = "";
                }
            }
        })
        .catch(error => console.error('Error fetching product:', error));
    }
    

}

loadProducts(); 
