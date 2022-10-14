let maleElemetRadio = document.getElementById("male")
let femaleElemetRadio = document.getElementById("female")

let maleElementDiv = document.getElementById("divmale")
let femaleElementDiv = document.getElementById("divfemale")

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