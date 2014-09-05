// edit one
public walk_through_walls() {
	if (colliding_to_wall) {
		walk_through();
	}
	
}


public fly() {
	if (button_A_clicked()) {
		player.image.position.y += 1;
	}
}
