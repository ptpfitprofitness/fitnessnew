function delete_photo(photo_id,album_id){
	var flag = false;
	jConfirm('Are you sure, you want to delete this photo?', 'Confirmation...', function(r) {
		if(r) {
			window.location = SITE_URL+"photos/photos/delete_photo/id:"+photo_id+"/album_id:"+album_id;
		} 
	});
	return false;
}

function delete_album(album_id){
	var flag = false;
	jConfirm('Are you sure, you want to delete this album?', 'Confirmation...', function(r) {
		if(r) {
			window.location = SITE_URL+"photos/photos/delete_album/album_id:"+album_id;
		} 
	});
	return false;
}