<footer class="footer">
    <div class="text-center">
        <p>Copyright © 2016 - 2024 Jewelxy Marketplace Pvt Ltd.</p>
    </div>
    <button id="back-top" style="display:none; position: fixed; bottom: 20px; right: 20px; background-color: var(--theme-dark-color); color: white; border: none; padding: 10px; border-radius: 5px; cursor: pointer;">
        ↑ Back to Top
    </button>
</footer>


<script>
    window.onscroll = function() {
        let backTopBtn = document.getElementById("back-top");
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            backTopBtn.style.display = "block";
        } else {
            backTopBtn.style.display = "none";
        }
    };

    document.getElementById("back-top").onclick = function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

</script>
