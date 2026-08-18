<link rel="stylesheet" href="/typemania/css/modal.css?v=<?php echo time(); ?>">

<div id="game-modal" class="game-modal-overlay" style="display: none;">
    <div class="game-modal-card" style="border: 3px solid <?php echo $active_theme['color']; ?>; box-shadow: 0px 0px 30px <?php echo $active_theme['color']; ?>80;">
        <h2 id="modal-title" class="modal-heading">MATCH COMPLETE</h2>
        <p id="modal-desc" class="modal-body-text"></p>
        
        <div id="modal-stats-container" class="modal-stats-grid">
           
        </div>

        <div class="modal-actions">
            <a href="./play.php" class="btn-pill-control" style="border: 2px solid <?php echo $active_theme['color']; ?>;">EXIT</a>
            <button id="modal-btn-retry" class="btn-pill-control" style="border: 2px solid <?php echo $active_theme['color']; ?>;">RETRY</button>
        </div>
    </div>
</div>