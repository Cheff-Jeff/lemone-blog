</main>
</body>

<script src="../src/js/main.js" defer></script>
<?php if (isset($js)) : ?>
  <script src="../src/js/<?= $js; ?>.js" type="module" defer></script>
<?php endif; ?>
</html>