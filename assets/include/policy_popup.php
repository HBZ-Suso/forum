<?php

echo '
<div class="policy-popup theme-main-color-1">
    By viewing this page you agree to our policies. You can view them <a href="/forum/assets/site/policy.php">here</a>.
    <button id="hide-policy-popup" class="theme-main-color-2 hover-theme-main-color-1">I accept, hide this message.</button>
</div>


<style>
    .policy-popup {
        position: fixed;
        bottom: 0px;
        left: 0px;
        height: 110px;
        width: 200px;
        padding: 10px;
        z-index: 5;
        font-size: 15px;
        border-top-right-radius: 10px;
        background-color: var(--main-background-lighter-ten);
    }

    .policy-popup > button {
        cursor: pointer;
        border: none;
        margin-top: 4px;
        font-size: 15px;
        border-radius: 5px;
        background-color: var(--main-background-lighter-six);
    }

    .policy-popup > button:hover {
        background-color: var(--main-background-lighter-eleven);
    }
</style>


<script>
    document.getElementById("hide-policy-popup").addEventListener("click", (e) => {
        document.cookie = "policy-agreed=true; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
        document.querySelector(".policy-popup").style.display = "none";
    });
</script>
';