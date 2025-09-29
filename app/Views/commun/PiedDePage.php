<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemple Page avec Footer</title>
    <style>
        footer {
            background-color: #222;
            color: #f1f1f1;
            padding: 20px 40px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
        }

        footer .footer-section {
            flex: 1 1 200px;
            margin: 10px;
        }

        footer h4 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #fff;
        }

        footer p, footer a {
            font-size: 0.9rem;
            margin: 5px 0;
            color: #bbb;
            text-decoration: none;
        }

        footer a:hover {
            color: #fff;
        }

        .footer-bottom {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid #444;
            padding-top: 10px;
            font-size: 0.8rem;
            color: #aaa;
        }
    </style>
</head>
<body>


<footer>
    <div class="footer-section">
        <h4>Mentions légales</h4>
        <p><a href="#">Consulter les mentions légales</a></p>
    </div>

    <div class="footer-section">
        <h4>Hébergeur</h4>
        <p>OVH SAS<br>
            2 rue Kellermann<br>
            59100 Roubaix, France</p>
    </div>

    <div class="footer-section">
        <h4>Contact</h4>
        <p>Email : <a href="mailto:contact@monsite.com">contact@monsite.com</a></p>
        <p>Tél : +33 1 23 45 67 89</p>
    </div>

    <div class="footer-section">
        <h4>Notre société</h4>
        <p>DevWeb Solutions<br>
            Création de sites et applications web<br>
            SIRET : 123 456 789 00010</p>
    </div>

    <div class="footer-bottom">
        &copy; 2025 DevWeb Solutions - Tous droits réservés
    </div>
</footer>

</body>
</html>
