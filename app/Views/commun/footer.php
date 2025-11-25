<?= link_tag('styles/commun/footer.css'); ?>
<footer>

    <div class="footer-section">
        <h4>Mentions légales</h4>
<!--        <p><a href="MentionsLegales.php">Consulter les mentions légales</a></p>-->
        <?= anchor(base_url().'MentionLegale', '<p>Consulter les mentions légales</p>'); ?>
    </div>

    <div class="footer-section">
        <h4>Hébergeur</h4>
        <p>Local<br>
            1 rue Horizon Vert<br>
            37130 Chambray-lès-Tours, France</p>
    </div>

    <div class="footer-section">
        <h4>Contact</h4>
        <p>Email : <a href="mailto:bts.sio.slam.stm@gmail.com">bts.sio.slam.stm@gmail.com</a></p>
        <p>Tél : 06 01 01 01 01</p>
    </div>

    <div class="footer-section">
        <h4>Notre société</h4>
        <p>BLUT - Block, Learn, Understand, Train<br>
            Création de sites et applications web<br></p>
    </div>

    <div class="footer-bottom">
        &copy; 2025 BLUT - Tous droits réservés
    </div>
</footer>
</body>
</html>
