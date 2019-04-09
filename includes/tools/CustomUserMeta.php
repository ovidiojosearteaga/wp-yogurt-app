<?php 
namespace tools;
/**
 *
 * @author Ovidio Jose Arteaga
 *        
 */
	
class CustomUserMeta
{

	public $listFields;

	function __construct($listFields)
	{
    $this->listFields = $listFields;

		add_action('show_user_profile', array($this, 'customUserProfileFields'));
		add_action('edit_user_profile', array($this, 'customUserProfileFields'));

		add_action( 'personal_options_update', array($this, 'updateExtraProfileFields'));
		add_action( 'edit_user_profile_update', array($this, 'updateExtraProfileFields'));
	}

	function customUserProfileFields($user) 
	{
		echo "<table class='form-table'>";
		foreach ($this->listFields as $field) {
			switch ($field['type']) {
				case 'text':
					$this->putTextField($field, $user);
					break;
				case 'number':
					$this->putNumberField($field, $user);
					break;
				case 'select':
					$this->putSelectField($field, $user);
					break;
				case 'text-info':
					$this->putTextInfoField($field, $user);
					break;
				default:
					$this->putTextField($field, $user);
					break;
			}
		}
    echo "</table>";
	}

	function updateExtraProfileFields($userId) 
	{
		/*
		if (current_user_can('edit_user', $userId))
			return;
		*/
		foreach ($this->listFields as $field) {
			update_user_meta( $userId, $field['id'], $_POST[$field['id']] );    
		}
	}

	function putTextField($field, $user) 
	{
		?>
		<tr>
			<th>
				<label for="<?=$field['id']?>"><?=$field['label']?></label>
			</th>
			<td>
				<input type="<?=$field['type']?>" name="<?=$field['id']?>" id="<?=$field['id']?>" placeholder="<?=$field['placeholder']?>" value="<?=esc_attr(get_the_author_meta($field['id'], $user->ID))?>" class="<?=$field['class']?>"/>
			</td>
		</tr>
    <?php
	}

	function putNumberField($field, $user) 
	{
		?>
		<tr>
			<th>
				<label for="<?=$field['id']?>"><?=$field['label']?></label>
			</th>
			<td>
				<input type="<?=$field['type']?>" name="<?=$field['id']?>" id="<?=$field['id']?>" placeholder="<?=$field['placeholder']?>" value="<?=esc_attr(get_the_author_meta($field['id'], $user->id))?>" class="<?=$field['class']?>" max="<?=$field['max']?>" min="<?=$field['min']?>" step="<?=$field['step']?>" />
			</td>
		</tr>
    <?php
	}

	function putSelectField($field, $user) 
	{
		$valueSelected = get_the_author_meta($field['id'], $user->ID);
		?>
		<tr>
			<th>
				<label for="<?=$field['id']?>"><?=$field['label']?></label>
			</th>
			<td>
				<select name="<?=$field['id']?>" id="<?=$field['id']?>" class="js_field-country select2-hidden-accessible wc-enhanced-select $field['class']" style="width: 25em;" tabindex="-1" aria-hidden="true" <?=$field['multiple']?>>
					<?php 
					foreach ($field['options'] as $option) {
						$isSelected = $option['value'] == $valueSelected ? 'selected' : 'false';
						echo "<option $isSelected value='".$option['value']."'>".$option['string']."</option>";
					} 
					?>
				</select>
			</td>
		</tr>
    <?php

    /*
    wc_enqueue_js( "
	  jQuery( ':input.wc-enhanced-select' ).filter( ':not(.enhanced)' ).each( function() {
	    var select2_args = { minimumResultsForSearch: 5 };
	    jQuery( this ).select2( select2_args ).addClass( 'enhanced' );
	  });" );
		*/
		}

		function putTextInfoField($field, $user)
		{
			?>
			<tr>
				<th>
					<label for="<?=$field['id']?>"><?=$field['label']?></label>
				</th>
				<td>
					<p><?=$field['text']?></p>
				</td>
			</tr>
    	<?php
		}
}