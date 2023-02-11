<?php

//print_r($this->mainoptions);
function dzsprx_parse_layer(&$parallax_animation_arr, $layer){
	$arr_transition = array();




	$mlayer = array(
		'layer_transition_in'=>'',
		'layer_transition_out'=>'',
		'layer_transition_custom'=>'',
	);



	$layer = array_merge($mlayer, $layer);


	if($layer['layer_transition_custom']&&$layer['layer_transition_custom']!='e30='){


		try{




			$custom_transition = json_decode(base64_decode($layer['layer_transition_custom']),true);


//			print_rr($custom_transition);

			foreach ($custom_transition as $lab => $val){

				$cpt = $val;


				$sw_found = false;
				$arr = array(
					'property'=>$lab,

					'value'=>'{{val}}px',
					'initial'=>$val['initial'],
					'mid'=>$val['mid'],
					'final'=>$val['final'],
				);

				if($lab=='left'||$lab=='top'){
					$arr['value'] = '{{val}}px';
				}
				if($lab=='opacity'){
					$arr['value'] = '{{val}}';
				}
				if($lab=='scale'){
					$arr['property'] = 'transform';
					$arr['value'] = 'scale({{val}})';
				}
				if($lab=='rotate'){


					foreach ($parallax_animation_arr as $lab3=>$val3){
						if($val3['property']=='transform'){
							$sw_found = true;



							$parallax_animation_arr[$lab3]['value'].=' rotate({{val2}}deg)';
							$parallax_animation_arr[$lab3]['initial2']=$val['initial'];
							$parallax_animation_arr[$lab3]['mid2']=$val['mid'];
							$parallax_animation_arr[$lab3]['final2']=$val['final'];


						}
					}

					if($sw_found == false){

						$arr['property'] = 'transform';
						$arr['value'] = 'rotate({{val}}deg)';
					}
				}


				if($sw_found == false) {
					array_push( $parallax_animation_arr, $arr );
				}

			}



		}catch(Exception $exc){
			print_r($exc);
		}
	}else{


		if($layer['layer_transition_in']=='slide-in'){


			$arr = array(
				'property'=>'top',
				'value'=>'{{val}}px',
				'initial'=>'-100',
				'mid'=>'0',
				'final'=>'0',
			);


			array_push($parallax_animation_arr, $arr);



		}

		if($layer['layer_transition_in']=='fade-in'){


			$arr = array(
				'property'=>'opacity',
				'value'=>'{{val}}',
				'initial'=>'0',
				'mid'=>'1',
				'final'=>'1',
			);


			array_push($parallax_animation_arr, $arr);



		}

		if($layer['layer_transition_in']=='rotate-in'){


			$arr = array(
				'property'=>'transform',
				'value'=>'rotate({{val}}deg)',
				'initial'=>'-30',
				'mid'=>'0',
				'final'=>'0',
			);


			array_push($parallax_animation_arr, $arr);



		}

		if($layer['layer_transition_in']=='scale-in'){


			$arr = array(
				'property'=>'transform',
				'value'=>'rotate({{val}}deg)',
				'initial'=>'0.5',
				'mid'=>'1',
				'final'=>'1',
			);


			array_push($parallax_animation_arr, $arr);



		}

		if($layer['layer_transition_in']=='fade-slide-in'){


			$arr = array(
				'property'=>'opacity',
				'value'=>'{{val}}',
				'initial'=>'0',
				'mid'=>'1',
				'final'=>'1',
			);

			$arr2 = array(
				'property'=>'top',
				'value'=>'{{val}}px',
				'initial'=>'-100',
				'mid'=>'0',
				'final'=>'0',
			);


			array_push($parallax_animation_arr, $arr);
			array_push($parallax_animation_arr, $arr2);



		}
		if($layer['layer_transition_out']=='slide-out'){


			$sw_add = true;
			foreach ($parallax_animation_arr as $lab=>$anim){

				if($anim['property']=='top'){
					$parallax_animation_arr[$lab]['final'] = '100';
					$sw_add = false;
					break;
				}
			}

			if($sw_add){

				$arr = array(
					'property'=>'top',
					'value'=>'{{val}}px',
					'initial'=>'0',
					'mid'=>'0',
					'final'=>'100',
				);

				array_push($parallax_animation_arr, $arr);

			}

		}
		if($layer['layer_transition_out']=='fade-out'){


			$sw_add = true;
			foreach ($parallax_animation_arr as $lab=>$anim){

				if($anim['property']=='opacity'){
					$parallax_animation_arr[$lab]['final'] = '0';
					$sw_add = false;
					break;
				}
			}

			if($sw_add){

				$arr = array(
					'property'=>'opacity',
					'value'=>'{{val}}',
					'initial'=>'1',
					'mid'=>'1',
					'final'=>'0',
				);



				array_push($parallax_animation_arr, $arr);

			}

		}
		if($layer['layer_transition_out']=='rotate-out'){


			$sw_add = true;
			foreach ($parallax_animation_arr as $lab=>$anim){

				if($anim['property']=='transform'){
					$parallax_animation_arr[$lab]['final'] = '15';
					$sw_add = false;
					break;
				}
			}

			if($sw_add){

				$arr = array(
					'property'=>'transform',
					'value'=>'rotate({{val}}deg)',
					'initial'=>'0',
					'mid'=>'0',
					'final'=>'15',
				);



				array_push($parallax_animation_arr, $arr);

			}

		}
		if($layer['layer_transition_out']=='scale-out'){


			$sw_add = true;
			foreach ($parallax_animation_arr as $lab=>$anim){

				if($anim['property']=='transform'){
					$parallax_animation_arr[$lab]['final'] = '0.5';
					$sw_add = false;
					break;
				}
			}

			if($sw_add){

				$arr = array(
					'property'=>'transform',
					'value'=>'scale({{val}})',
					'initial'=>'1',
					'mid'=>'1',
					'final'=>'0.5',
				);



				array_push($parallax_animation_arr, $arr);

			}

		}
		if($layer['layer_transition_out']=='fade-slide-out'){


			$sw_add = true;
			foreach ($parallax_animation_arr as $lab=>$anim){

				if($anim['property']=='top'){
					$parallax_animation_arr[$lab]['final'] = '100';
					$sw_add = false;
				}
				if($anim['property']=='opacity'){
					$parallax_animation_arr[$lab]['final'] = '0';
					$sw_add = false;
				}
			}

			if($sw_add){

				$arr = array(
					'property'=>'opacity',
					'value'=>'{{val}}',
					'initial'=>'1',
					'mid'=>'1',
					'final'=>'0',
				);

				$arr2 = array(
					'property'=>'top',
					'value'=>'{{val}}px',
					'initial'=>'0',
					'mid'=>'0',
					'final'=>'100',
				);


				array_push($parallax_animation_arr, $arr);
				array_push($parallax_animation_arr, $arr2);

			}

		}
	}
}