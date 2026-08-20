<div class="modal" id="customizeProfileModal">
    <div class="custom-modal">
        <div class="modal-header">
            <h3 class="font-glitch" style="margin: 0;">CUSTOMIZE PROFILE</h3>
            <button type="button" class="modal-close-btn" id="modalCloseX">&times;</button>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="modal-body">

                <div class="modal-preview-wrapper mb-4 text-center">
                    <span class="modal-label d-block mb-2">LIVE PREVIEW</span>
                    <div class="avatar-box mx-auto" id="previewCircle" style="border-color: <?php echo $circle_color; ?>; box-shadow: 0 0 18px <?php echo $circle_color; ?>;">
                        <span id="previewText" style="color: <?php echo $letter_color; ?>;"><?php echo $avatar_initials; ?></span>
                    </div>
                </div>

                <div class="modal-group">
                    <label for="usernameInput" class="modal-label">USERNAME</label>
                    <input type="text" id="usernameInput" name="username" class="custom-input" value="<?php echo htmlspecialchars($username); ?>" maxlength="16" required placeholder="ENTER USERNAME">
                </div>

                <div class="modal-group">
                    <label class="modal-label">CIRCLE BORDER COLOR</label>
                    <div class="color-palette">
                        <?php foreach ($valid_circle_colors as $color): ?>
                            <label class="color-swatch-label">
                                <input type="radio" name="circle_color" value="<?php echo $color; ?>" <?php echo ($circle_color === $color) ? 'checked' : ''; ?>>
                                <span class="color-swatch" style="background-color: <?php echo $color; ?>;"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="modal-group">
                    <label class="modal-label">LETTER COLOR</label>
                    <div class="color-palette">
                        <?php foreach ($valid_letter_colors as $color): ?>
                            <label class="color-swatch-label">
                                <input type="radio" name="letter_color" value="<?php echo $color; ?>" <?php echo ($letter_color === $color) ? 'checked' : ''; ?>>
                                <span class="color-swatch" style="background-color: <?php echo $color; ?>;"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="stats-btn btn-cancel-modal" id="modalCancelBtn">CANCEL</button>
                <button type="submit" class="stats-btn btn-save-modal">SAVE CHANGES</button>
            </div>
        </form>
    </div>
</div>