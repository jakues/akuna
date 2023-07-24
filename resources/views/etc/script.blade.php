<script>
    // function to show other category
    var categoryEle = document.getElementById('custom');

    function handleCategory(value) {
        if (value === 'custom') {
            categoryEle.style.display = 'block';
        } else {
            categoryEle.style.display = 'none';
        }
    }
</script>
