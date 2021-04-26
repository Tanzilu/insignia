const protocol = window.location.protocol
const hostname = `${protocol  }//${  window.location.hostname}`

window.localserver = ':8000'

if (process.env.NODE_ENV === 'production') {
  window.url = `${hostname  }/`
} else {
  window.url = `${hostname + localserver  }/`
}