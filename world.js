window.addEventListener("DOMContentLoaded", () => {
  const lookupBtn = document.getElementById("lookup");
  const resultDiv = document.getElementById("result");

  lookupBtn.addEventListener("click", function () {
    const country = document.getElementById("country").value;

    fetch(`world.php?country=${encodeURIComponent(country)}`)
      .then((response) => response.text())
      .then((data) => {
        resultDiv.innerHTML = data;
      })
      .catch((error) => {
        resultDiv.innerHTML = "Error fetching data.";
        console.error(error);
      });
  });
});
