<div>
    Giới tính:
    <input id="1" type="radio" name="gender" value="Male" onclick="showInfo()">Nam xịn
    <input id="2" type="radio" name="gender" value="FeMale" onclick="showInfo()">Nữ chuẩn
</div>
<div id="ww1" style="display:none">
    <p>Nam thì khuyến mãi sửa tắm toàn thân</p>
</div>
<div id="ww2" style="display:none">
    <p>Nữ thêm 10% </p>
</div>

    <script>
        let maleElemetRadio = document.getElementById("1")
        let femaleElemetRadio = document.getElementById("2")

        let maleElementDiv = document.getElementById("ww1")
        let femaleElementDiv = document.getElementById("ww2")

        maleElemetRadio.onchange = function() {
            if (this.checked) {
                maleElementDiv.style.display = "block"
                femaleElementDiv.style.display = "none"

            }
        }
        femaleElemetRadio.onchange = function() {
            if (this.checked) {
                femaleElementDiv.style.display = "block"
                maleElementDiv.style.display = "none"
            }
        }
    </script>
