<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="../../images/logo.png">
    <link rel="shortcut icon" type="image/png" href="../../images/logo.png">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="login-background">
            <div class="background-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
        </div>

        <div class="login-content">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-logo">
                        <img src="../../images/obo.png" alt="LGU Logo">
                    </div>
                    <h1 class="login-title">Welcome Back</h1>
                    <p class="login-subtitle">Sign in to your account</p>
                </div>

                <form class="login-form" action="#" method="POST">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-container">
                            <input type="text" id="username" name="username" class="form-input" placeholder="Enter your username" required>
                            <span class="input-icon">👤</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-container">
                            <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <span class="toggle-icon">👁️</span>
                            </button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-container">
                            <input type="checkbox" name="remember" class="checkbox">
                            <span class="checkmark"></span>
                            <span class="checkbox-label">Remember me</span>
                        </label>
                        <a href="#" class="forgot-password">Forgot Password?</a>
                    </div>

                    <button type="submit" class="login-btn">
                        <span class="btn-text">Sign In</span>
                        <span class="btn-icon">→</span>
                    </button>
                </form>

                <div class="login-footer">
                   
                    <a href="../../index.php" class="back-home">← Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = '👁️';
            }
        }

        // Form validation and submission
        document.querySelector('.login-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const remember = document.querySelector('input[name="remember"]').checked;

            if (username && password) {
                // Add loading state
                const submitBtn = document.querySelector('.login-btn');
                const btnText = document.querySelector('.btn-text');
                const btnIcon = document.querySelector('.btn-icon');

                btnText.textContent = 'Signing In...';
                btnIcon.textContent = '⏳';
                submitBtn.disabled = true;

                // Send login request to API
                fetch('../../api/auth/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password,
                        remember: remember
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Login successful
                        btnText.textContent = 'Success!';
                        btnIcon.textContent = '✓';
                        submitBtn.disabled = false; // Remove disabled state to stop spinning
                        
                        // Show success message
                        showMessage('Login successful! Redirecting...', 'success');
                        
                        // Redirect to appropriate dashboard
                        setTimeout(() => {
                            window.location.href = data.data.redirect_url;
                        }, 1500);
                    } else {
                        // Login failed
                        btnText.textContent = 'Sign In';
                        btnIcon.textContent = '→';
                        submitBtn.disabled = false;
                        showMessage(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btnText.textContent = 'Sign In';
                    btnIcon.textContent = '→';
                    submitBtn.disabled = false;
                    showMessage('An error occurred. Please try again.', 'error');
                });
            } else {
                showMessage('Please fill in all fields', 'error');
            }
        });

        // Function to show messages
        function showMessage(message, type) {
            // Remove existing messages
            const existingMessage = document.querySelector('.message');
            if (existingMessage) {
                existingMessage.remove();
            }

            // Create message element
            const messageDiv = document.createElement('div');
            messageDiv.className = `message message-${type}`;
            messageDiv.textContent = message;
            
            // Style the message
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                color: white;
                font-weight: 500;
                z-index: 1000;
                animation: slideIn 0.3s ease-out;
                ${type === 'success' ? 'background: #27ae60;' : 'background: #e74c3c;'}
            `;

            // Add animation styles
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);

            // Add to page
            document.body.appendChild(messageDiv);

            // Remove after 5 seconds
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 5000);
        }
    </script>
</body>

</html>