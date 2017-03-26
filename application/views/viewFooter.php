	</div>
</div>
			
	<footer id="footer" class="Footer bg-dark dker">
      <p>Project Manager</p>
    </footer>
	
    <script src="<?php echo HTTP_LIB_PATH ?>jquery/jquery.min.js"></script>
    <script src="<?php echo HTTP_LIB_PATH ?>bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo HTTP_LIB_PATH ?>metismenu/metisMenu.min.js"></script>
	<script src="<?php echo HTTP_LIB_PATH ?>screenfull/screenfull.js"></script>
	<script src="<?php echo HTTP_JS_PATH ?>core.min.js"></script>
	<script src="<?php echo HTTP_JS_PATH ?>app.js"></script>
	<script src="<?php echo HTTP_LIB_PATH ?>loading-overlay/loadingoverlay.js"></script>
    
	
	<?php 
		if (isset($pluginsJquery)) {
			foreach($pluginsJquery as $key => $plugin) {
				echo '<script src="' . $plugin . '"></script>';
			}
		}
	?>
	
	</body>
</html>	
	