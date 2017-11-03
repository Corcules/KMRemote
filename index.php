<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <title>KMRemote</title>
        <link rel="apple-touch-icon" href="/wp-content/themes/kmremote/images/apple-touch-icon-iphone.png">
        <link href="/wp-content/themes/kmremote/assets/css/font-awesome.css" media="screen" rel="stylesheet" type="text/css">
        <link href="/wp-content/themes/kmremote/assets/css/jquery-ui.css" media="screen" rel="stylesheet" type="text/css">
        <link href="/wp-content/themes/kmremote/assets/css/tooltipster.css" media="screen" rel="stylesheet" type="text/css">
		<link href="/wp-content/themes/kmremote/style.css" media="screen" rel="stylesheet" type="text/css">
	</head>
	<body id="body" class="">
    
    	

    	<!-- MENU HANDLER-->
    	<div id="top-menu-panel-handler"></div>
    	
    	<!-- MENU -->
    	<div id="top-menu-panel">
        	<div class="inner">
            	<div class="section" id="main-menu">
                	<div class="section-titre">Menu</div>
                    <div class="section-content">                	
                        <div id="action-edit">Edit</div>
                        <div id="action-run">Run</div>
                        <div id="dynamic-board-switch-toggle">
                            Auto Switch Boards
                            <input type="checkbox" class="bool" name="action-dynamic-board-switch-toggle" id="action-dynamic-board-switch-toggle"><label for="action-dynamic-board-switch-toggle"></label>
                        </div>
                	    <div id="action-new-board">New Board</div>
                	    <div id="action-edit-board">Edit Board</div>
                	    <div id="action-delete-board">Delete board</div>
                	</div>
            	</div>
            	<div class="section" id="boards-manager">
                	<div class="section-titre">Boards</div>
                	<div class="section-content"></div>
            	</div>
        	</div>
    	</div>
    	

    	<!-- BOARDS --> 
        <div id="boards"></div>
  

        <!--CONFIRM DELETE -->        
        <div class="confirm" id="confirm-delete-board">
            <div class="inner">
                <div class="content">
                    <div class="title">Sure ?</div>
                    <div>Please confirm the deletion of board <span class="board-title">titre</span></div>
                    <div>All widgets on this board will be delete too.</div>
                </div>
                <div class="bottom-controls">
                    <div class="control left cancel action-cancel-board-delete">Cancel</div>
                    <div class="control right delete action-confirm-board-delete">Delete</div>
                </div>
            </div>
        </div>


		<div class="panel" id="panel-board">
			<div class="inner">
    			<div class="main">
    				<div class="title"><span>Edit board</span>
        				<div class="controls">
            				<div class="control left cancel" id="action-panel-board-cancel">Cancel</div>
            				<div class="control right" id="action-panel-board-save">OK</div>
        				</div>
    				</div>
    				<div class="content">
    					<form name="board">
	    					
	    					<input type="hidden" name="action" value="saveboard" data-default="saveboard">
	    					<input type="hidden" name="board_id" value="">
	    					
    						<div class="section-title">Description</div>
    						<div class="bloc">
    							<div class="field">
    								<div class="field-label">Title</div>
    								<div class="field-input input-text" id="board-title">
        								<input type="text" name="board_title">
    								</div>
    							</div>
    							<div class="field">
    								<div class="field-label">Note</div>
    								<div class="field-input input-textarea" id="board-note">
        								<textarea name="board_note"></textarea>
    								</div>
    							</div>
    						</div>
    						<div class="section-title">Appearance</div>
    						<div class="bloc">
    							<div class="field">
    								<div class="field-label">Background color</div>
    								<div class="field-input input-color" id="board-background-color">
        								<input type="hidden" name="board_background_color" data-default="">
        								<div class="preview"></div>
    								</div>
    							</div>
    							<div class="field">
    								<div class="field-label">Icon</div>
    								<div class="field-input input-icon" id="board-icon">
        								<input type="hidden" name="board_icon" data-default="">
        								<div class="preview"><i></i></div>
    								</div>
    							</div>
    						</div>
    						<div class="section-title">Behaviour</div>
    						<div class="bloc">
    							<div class="field">
    								<div class="field-label">Switch on application</div>
    								<div class="field-input input-text" id="board-switch-on-app">
	    								<input type="text" name="board_switch_on_app" value="" autocapitalize="none">
	    								<div id="action-listen-app"></div>
    								</div>
    								<div class="field-description">
                                        Activate this board when a specific application is in the foreground.
                                        <br>
                                        <br>
    									Tap on the listen button, bring the application to front on the mac, then stop listening.
                                        <br>
                                        or
                                        <br>
                                        Write the name of the application as it appear on the information panel, without extension (".app").
    								</div>
    							</div>
    							<div id="switch-on-finder">
        							<div class="field">
            							<div class="field-label">Switch on path</div>
            							<div class="field-input input-text" id="board-switch-on-path">
                							<input type="text" name="board_switch_on_path" value="" autocapitalize="none">
                							<div id="action-listen-path"></div>
            							</div>
            							<div class="field-description">
                							Activate this board when a specific Finder window is in the foreground.
                							<br>
                							<br>
                							Tap on the listen button, open the folder on your mac then stop listening.
                							<br>
                							or
                							<br>
                							Write the full path of the folder (ex:/Users/yourusername/...).
            							</div>
        							</div>
    							</div>
    						</div>
    					</form>
    				</div>
    			</div><!-- main -->
                <div class="picker"></div>
			</div><!-- inner -->
		</div>


		<div class="panel" id="panel-widget">
			<div class="inner">
    			<div class="main">
    				<div class="title"><span>Edit widget</span>
	    				<div class="controls">
            				<div class="control left cancel" id="action-panel-widget-cancel">Cancel</div>
            				<div class="control right" id="action-panel-widget-save">OK</div>
        				</div>
    				</div>
    				<div class="content">
    					<form name="widget">
    						<input type="hidden" name="action" value="savewidget" data-default="savewidget">
    						<input type="hidden" name="widget_id" value="" data-default="">
    						<input type="hidden" name="board_id" value="" data-default="">
    						
    						<input type="hidden" name="widget_sC" value="" data-default="">
    						<input type="hidden" name="widget_sR" value="" data-default="">
    						<input type="hidden" name="widget_eC" value="" data-default="">
    						<input type="hidden" name="widget_eR" value="" data-default="">
    						
    						<div class="section-title">Description</div>
    						<div class="bloc">
    							<div class="field">
    								<div class="field-label">Title</div>
    								<div class="field-input input-text" id="widget-title">
	    								<input type="text" name="widget_title">
    								</div>
    							</div>
    							<div class="field">
    								<div class="field-label">Note</div>
    								<div class="field-input input-textarea" id="widget-note">
	    								<textarea name="widget_note"></textarea>
    								</div>
    							</div>
    						</div>
    						<div class="section-title">Action</div>
    						<div class="bloc">
	    						<div class="field">
    								<div class="field-label">Action</div>
    								<div class="field-input input-action" id="widget-action">
	    								<input type="hidden" name="widget_action" data-default="">
	    								<div class="preview"></div>
    								</div>	
    							</div>
    						</div>
    						<div class="section-title">Appearance</div>
    						<div class="bloc">
    							<div class="field">
    								<div class="field-label">Background color</div>
    								<div class="field-input input-color" id="widget-background-color">
	    								<input type="hidden" name="widget_background_color" data-default=""> 
	    								<div class="preview"></div>
    								</div>
    							</div>
    							<div class="field">
    								<div class="field-label">View</div>
    								<div class="field-input input-choice" id="widget-view">
	    								<input type="radio" name="widget_view" id="widget_view_icon" value="view-icon" checked><label for="widget_view_icon">Icon</label>
	    								<input type="radio" name="widget_view" id="widget_view_title" value="view-title"><label for="widget_view_title">Title</label>
										<input type="radio" name="widget_view" id="widget_view_both" value="view-both"><label for="widget_view_both">Both</label>
        							</div>
    							</div>
    							<div class="widget-view-icon">
    								<div class="field">
    									<div class="field-label">Icon</div>
    									<div class="field-input input-icon" id="widget-icon">
	    									<input type="hidden" name="widget_icon" data-default="">
	    									<div class="preview"><i class=""></i></div>
    									</div>
    								</div>
    								<div class="field">
    									<div class="field-label">Icon color</div>
    									<div class="field-input input-color" id="widget-icon-color">
	    									<input type="hidden" name="widget_icon_color" data-default="">
	    									<div class="preview"></div>
    									</div>
    								</div>
    							</div>
    							<div class="widget-view-title">
    								<div class="field">
    									<div class="field-label">Text color</div>
    									<div class="field-input input-color" id="widget-text-color">
	    									<input type="hidden" name="widget_text_color" data-default="">
	    									<div class="preview"></div>
    									</div>
    								</div>
    							</div>
    							<div class="widget-view-both">
        							<div class="field">
        								<div class="field-label">Position</div>
        								<div class="field-input input-choice" id="widget-view-both-position">
    	    								<input type="radio" name="widget_view_both_position" id="widget_view_both_position_above" value="above"><label for="widget_view_both_position_above">Above</label>
    	    								<input type="radio" name="widget_view_both_position" id="widget_view_both_position_right" value="right"><label for="widget_view_both_position_right">Right</label>
    	    								<input type="radio" name="widget_view_both_position" id="widget_view_both_position_below" value="below"><label for="widget_view_both_position_below">Below</label>
    	    								<input type="radio" name="widget_view_both_position" id="widget_view_both_position_left" value="left"><label for="widget_view_both_position_left">Left</label>	
        								</div>
        							</div>
    							</div>
    						</div>
    						<div class="bloc widget-delete">
    						    <div id="action-widget-delete">Delete widget</div>
    						</div>					
    					</form>
    				</div>
    			</div><!-- main -->
                <div class="picker"></div>
			</div><!-- inner -->
		</div>
				
        
        <!-- SELECT ICON -->
        <div class="clone">  
            <div class="picker-icon">
                <div class="title">
	                <span>Choose an icon</span>
	                <div class="controls">
		                <div class="control left back action-icon-picker-back">Back</div>
		                <div class="control right cancel action-icon-picker-cancel">Cancel</div>
	                </div>
	            </div>
	            <div class="toolbar">
                    <div class="search">
                        <input type="text" placeholder="Search" class="action-icon-search" autocapitalize="none" required>
                        <div class="reset action-icon-search-reset"></div>
                    </div>
                </div>
                <div class="content icon-grid">
                    <?php theme_helper_picker_icon_content(); ?>
                </div>
            </div>
        </div>
        
        

        <!-- SELECT COLOR -->
        <div class="clone">
            <div class="picker-color">
                <div class="title">
                    <span>Select a color</span>
                    <div class="controls">
                        <div class="control left back action-color-picker-back">Back</div>
                        <div class="control right cancel action-color-picker-cancel">Cancel</div>
                    </div>
                </div>
                <div class="content color-grid">
                    <?php theme_helper_picker_color_content(); ?>
                </div>
            </div>
        </div>
        
        
        <!-- SELECT ACTION -->        
        <div class="clone">
	    	<div class="picker-action">    
                <div class="title">
                    <span>Define widget action</span>
                    <div class="controls">
                        <div class="control left back action-action-picker-back">Back</div>
                        <div class="control right cancel action-action-picker-cancel">Cancel</div>
                    </div>
                </div>
                <div class="toolbar">
                    <div class="search">
                        <input type="text" placeholder="Search" class="action-action-search" autocapitalize="none" required>
                        <div class="reset action-action-search-reset"></div>
                    </div>
                    <div class="refresh action-macro-list-refresh">
                        <div class="loader"></div>
                    </div>
                    
                </div>
                <div class="content macro-list">
	                
                </div>
	    	</div>
        </div>


        
        <script>var ajaxurl = '<?php echo '/wp-admin/admin-ajax.php'; ?>';</script>
    	<script src="/wp-content/themes/kmremote/assets/js/fastclick.js"></script>
    	<script src="/wp-content/themes/kmremote/assets/js/inobounce.js"></script>
    	<script src="/wp-content/themes/kmremote/assets/js/taffy.js"></script>
    	<script src="/wp-content/themes/kmremote/assets/js/tinycolor.js"></script>
        <script src="/wp-content/themes/kmremote/assets/js/jquery.js"></script>
        <script src="/wp-content/themes/kmremote/assets/js/jquery-ui.js"></script>
        <script src="/wp-content/themes/kmremote/assets/js/jquery-ui-touch-punch.js"></script>
        <script src="/wp-content/themes/kmremote/assets/js/jquery-mobile-events.js"></script>
        <script src="/wp-content/themes/kmremote/assets/js/tooltipster-bundle.js"></script>
        <script src="/wp-content/themes/kmremote/assets/js/kmremote.js"></script>
	</body>
</html>