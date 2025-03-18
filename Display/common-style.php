<!-- Add Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        color: #333;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Montserrat', sans-serif;
        color: rgb(43, 69, 152);
    }

    h1 {
        font-weight: 700;
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        padding-bottom: 15px;
    }

    h1::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: rgb(43, 69, 152);
        border-radius: 2px;
    }

    .navbar {
        background-color: rgb(43, 69, 152);
        padding: 10px 20px;
        font-family: 'Poppins', sans-serif;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        font-size: 1rem;
        padding: 8px 15px;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .navbar a:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .site_header_3 {
        font-family: 'Montserrat', sans-serif;
    }

    .site_header_3 h6 {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 5px;
    }

    .site_header_3 h2 {
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 5px;
    }

    .site_header_3 span {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }

    footer {
        background-color: rgb(43, 69, 152);
        color: white;
        text-align: center;
        padding: 20px;
        margin-top: auto;
        font-family: 'Montserrat', sans-serif;
    }

    .main-content {
        padding: 2rem;
        flex: 1;
    }
</style>