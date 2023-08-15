<div class="container">
    <div class="foot">
        <div class="main">
            <div>
                <ul>
                    <li>
                        © 2020 Online mall
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // search
        $(".searchBtn").click(function (e) {
            location.href = "index.php?searchText=" + $(this).siblings(".searchTxt").val();
        });
    });
</script>