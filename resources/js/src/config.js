const protocol = window.location.protocol
const hostname = `${protocol  }//${  window.location.hostname}`

window.localserver = '' /**Please set local path on development mode */

if (process.env.NODE_ENV === 'production') {
  // mutate config for production...
  window.url = `${hostname  }/`
  // window.imgUrl = hostname+'/storage/';
} else {
  // mutate for development...
  window.url = `${hostname + localserver  }/`
  // window.imgUrl = hostname+localserver+'/storage/';
}