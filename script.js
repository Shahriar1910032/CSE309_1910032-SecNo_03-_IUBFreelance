const sortBtns = document.querySelectorAll(".job-id > *");

const sortItems = document.querySelectorAll(".jobs-container > *");

sortBtns.forEach((btn) => {
  btn.addEventListener("click", () => {
    sortBtns.forEach((btn) => btn.classList.remove("active"));
    btn.classList.add("active");

    const targetData = btn.getAttribute("data-target");

    sortItems.forEach((item) => {
      item.classList.add("delete");
      if (
        item.getAttribute("data-item") === targetData ||
        targetData === "all"
      ) {
        item.classList.remove("delete");
      }
    });
  });
});
document.getElementById("job-form").addEventListener("submit", async function (event) {
  event.preventDefault(); 

  const form = event.target;
  const formData = new FormData(form);
  const messageDiv = document.getElementById("form-message");

  try {
    const response = await fetch(form.action, {
      method: form.method,
      body: formData,
    });

    if (response.ok) {
      messageDiv.style.display = "block";
      messageDiv.style.color = "green";
      messageDiv.textContent = "Job posted successfully!";


      form.reset();

      setTimeout(() => {
        messageDiv.style.display = "none";
      }, 5000);
    } else {
      messageDiv.style.display = "block";
      messageDiv.style.color = "red";
      messageDiv.textContent = "There was an issue posting the job. Please try again.";
    }
  } catch (error) {
    console.error("Error:", error);
    messageDiv.style.display = "block";
    messageDiv.style.color = "red";
    messageDiv.textContent = "An error occurred. Please try again later.";
  }
});
document.getElementById('application-form').addEventListener('submit', function (event) {
  event.preventDefault();

  const form = event.target;
  const formData = new FormData(form);

  fetch('submit-application.php', {
    method: 'POST',
    body: formData
  })
    .then(response => response.text())
    .then(data => {
      const messageDiv = document.getElementById('response-message');
      messageDiv.style.display = 'block';
      messageDiv.innerHTML = data;
      messageDiv.style.color = 'green';

      form.reset();
    })
    .catch(error => {
      const messageDiv = document.getElementById('response-message');
      messageDiv.style.display = 'block';
      messageDiv.innerHTML = 'An error occurred while submitting the form. Please try again.';
      messageDiv.style.color = 'red';
    });
});


