import axios from 'axios'

const server = '/api/'

// Letters
export const lettersInfiniteGet = ({ page }) => { return axios.get(server + 'lettersInfinite?page=' + page) }
export const lettersGet = ({ searchPart, searchText }) => { return axios.get(server + 'letters?search_part=' + searchPart + '&search_text=' + searchText) }
export const lettersGetShow = ({ id, user_id }) => { return axios.get(server + 'letters/' + id + '/' + user_id) };
export const lettersPost = ({ user_id, animal_name, contents, letter_thumbnail, letter_favorites_count, letter_comments_count }) => { const config = { headers: { 'content-type': 'multipart/form-data' } }; let formData = new FormData(); formData.append('user_id', user_id); formData.append('animal_name', animal_name); formData.append('contents', contents);
  for (let i = 0; i < letter_thumbnail.length; i++) {
    let file = letter_thumbnail[i];
    formData.append('letter_thumbnail[' + i + ']', file);
  }
  formData.append('letter_favorites_count', letter_favorites_count); formData.append('letter_comments_count', letter_comments_count); return axios.post(server + 'letters', formData, config )};

// export const lettersPost2 = ({ user_id, animal_name, contents, letter_thumbnail, letter_favorites_count, letter_comments_count }) => { const config = { headers: { 'content-type': 'multipart/form-data' } }; let formData = new FormData(); formData.append('user_id', user_id); formData.append('animal_name', animal_name); formData.append('contents', contents);
//   for (let i = 0; i < letter_thumbnail.length; i++) {
//     let file = letter_thumbnail[i];
//     formData.append('letter_thumbnail[' + i + ']', file);
//   }
//   formData.append('letter_favorites_count', letter_favorites_count); formData.append('letter_comments_count', letter_comments_count); return axios.post(server + 'letters2', formData, config )};

export const lettersPut = ({ id, animal_name, contents, letter_thumbnail }) => {
  const config = { headers: { 'content-type': 'multipart/form-data' } }; let formData = new FormData();
  formData.append('animal_name', animal_name); formData.append('contents', contents); formData.append('letter_thumbnail', letter_thumbnail);
  return axios.post(server + 'letters/' + id + '?_method=PUT', formData, config )};
export const lettersDelete = ({ id }) => { return axios.delete(server + 'letters/' + id) };

// Favorites
export const favoritesGet = () => { return axios.get(server + 'favorites') };
export const favoritesPost = ({ letter_id, user_id }) => { return axios.post(server + 'favorites', { letter_id, user_id }) };
export const favoritesDelete = ({ id }) => { return axios.delete(server + 'favorites/' + id) };


