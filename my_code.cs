// edit one
public walk_through_walls() {
	// hotfix
	if (colliding_to_wall) {
		walk_through();
	}
	
}


public fly() {
	// edit two
	if (button_A_clicked()) {
		player.image.position.y += 1;
	}
}
