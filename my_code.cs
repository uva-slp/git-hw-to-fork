
public walk_through_walls() {
	// edit 2
	if (colliding_to_wall) {
		walk_through();
	}
	
}


public fly() {
	if (button_A_clicked()) {
		player.image.position.y += 1;
	}
}
