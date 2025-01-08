document.querySelector('.signup-form').addEventListener('submit', async function (event) {
  event.preventDefault();

  const form = event.target;
  const formData = new FormData(form);
  const messageDiv = document.getElementById('signup-message');

  try {
    const response = await fetch(form.action, {
      method: form.method,
      body: formData,
    });

    const result = await response.json();

    if (result.status === "success") {
      messageDiv.style.display = "block";
      messageDiv.innerHTML = `
          <p style="color: green; font-size: 1.2rem;">${result.message}</p>
          <a href="login.html" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background: #007BFF; color: white; text-decoration: none; border-radius: 5px;">Go to Login</a>
        `;
      form.reset();
    } else {
      messageDiv.style.display = "block";
      messageDiv.innerHTML = `<p style="color: red; font-size: 1.2rem;">${result.message}</p>`;
    }
  } catch (error) {
    console.error("Error:", error);
    messageDiv.style.display = "block";
    messageDiv.innerHTML = `<p style="color: red; font-size: 1.2rem;">An error occurred. Please try again later.</p>`;
  }
});
