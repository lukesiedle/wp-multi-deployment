<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div><h2>Rapid Deployment Configuration</h2>

<form action="<?php _e( self :: $form_action ) ?>" method="post">

<?php wp_nonce_field( 'save_settings', '_rapid_deployment_nonce' ) ?>

<h3>Set Environments</h3>
<p>Set the host name expect to be found in your local, staging, or production environments. This is tested at the beginning of the script.
	If the environment has changed, the home option and permalinks will be reset based on the new environment.</p>

	<table class="form-table">
		
	    <tbody>
			
			<tr>
	        	<td><label>Current environment</label></td>
	        	<td><?php _e( self :: $current ) ?></td>
	        </tr>

	        <tr>
	        	<td><label>Local Host Name</label></td>
	        	<td><input type="text" name="deployment_env_local" class="regular-text" value="<?php _e( $opts['local']) ?>" /></td>
	        </tr>
	        <tr>
	        	<td><label>Local Site URL</label></td>
	        	<td><input type="text" name="deployment_http_local" class="regular-text" value="<?php _e( $http['local']) ?>" /></td>
	        </tr>
	        <tr>
	        	<td><label>Staging Host Name</label></td>
	        	<td><input type="text" name="deployment_env_stage" class="regular-text" value="<?php _e( $opts['stage']) ?>" /></td>
	        </tr>
	        <tr>
	        	<td><label>Staging Site URL</label></td>
	        	<td><input type="text" name="deployment_http_stage" class="regular-text" value="<?php _e( $http['stage']) ?>" /></td>
	        </tr>
			
			<tr>
				<td><label>Production Host Name</label></td>
				<td><input type="text" name="deployment_env_prod" class="regular-text" value="<?php _e( $opts['prod']) ?>" /></td>
			</tr>
			<tr>
	        	<td><label>Production Site URL</label></td>
	        	<td><input type="text" name="deployment_http_prod" class="regular-text" value="<?php _e( $http['prod']) ?>" /></td>
	        </tr>
	    </tbody>
	
	</table>

<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>

</form>

</div>