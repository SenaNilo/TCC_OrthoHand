const show_pw_btn = document.querySelector('#show-passwd')
const show_pw_icon = show_pw_btn.querySelector('img')

const show_pw_btndois = document.querySelector('#show-passwddois')
const show_pw_icondois = show_pw_btndois.querySelector('img')

const show_pw_btntres = document.querySelector('#show-passwdtres')
const show_pw_icontres = show_pw_btntres.querySelector('img')

const pw_input = document.querySelector('#atualpassword')
const pw_inputdois = document.querySelector('#novapassword')
const pw_inputtres = document.querySelector('#password')

show_pw_btn.addEventListener('click', () => {
	pw_input.type = pw_input.type === 'password' 
		? 'text' 
		: 'password'

	// show_pw_icon.src = show_pw_icon.src.includes('um') 
	// 	? 'eye_closed.svg' 
	// 	: 'eye_open.svg'

})

show_pw_btndois.addEventListener('click', () => {
	pw_inputdois.type = pw_inputdois.type === 'password' 
		? 'text' 
		: 'password'

	// show_pw_icondois.src = show_pw_icondois.src.includes('dois') 
	// 	? 'eye_closed.svg' 
	// 	: 'eye_open.svg'

})

show_pw_btntres.addEventListener('click', () => {
	pw_inputtres.type = pw_inputtres.type === 'password' 
		? 'text' 
		: 'password'

	// show_pw_icontres.src = show_pw_icontres.src.includes('tres') 
	// 	? 'eye_closed.svg' 
	// 	: 'eye_open.svg'

})

