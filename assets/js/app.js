Dropzone.autoDiscover = false
Dropzone.prototype.defaultOptions.dictDefaultMessage = 'Klik atau seret file disini untuk mengunggah'
Dropzone.prototype.defaultOptions.dictRemoveFile = 'Hapus'

const aifos = function(){
	$('form.xform').each(function(){

		let
			form = $(this),
			action = form.attr('action'),
			method = form.attr('method')

		form.attr('onsubmit', 'return false')
		
		form.off('submit').on('submit', function(){
			Pace.start()
			$.ajax({
				url : action,
				type : method,
				data : form.serializeArray(),
				success : function(res){
					Pace.stop()
					let fields = [
						form.find('input'),
						form.find('select'),
						form.find('textarea')
					]

					for(i in fields){

						fields[i].parent().find('.help-block').remove()
						fields[i].parent().removeClass('has-error')
					}

					if('error' == res.status) {
						for(i in res.errors) {
							
							let {field, message} = res.errors[i]

							let fields = [
								form.find('input[name="'+field+'"]'),
								form.find('select[name="'+field+'"]'),
								form.find('textarea[name="'+field+'"]')
							]

							for(i in fields){

								fields[i].parent().find('.help-block').remove()
								fields[i].parent().addClass('has-error')
								fields[i].parent().append(
									'<span class="help-block">' + message +
									'</span>'
								)
							}
						}

					}

					if (res.reset_fields) {
						for(i in res.reset_fields) {

							let name = res.reset_fields[i]
							
							form.find('input[name="'+name+'"]').val('')
							form.find('select[name="'+name+'"]').val('')
							form.find('textarea[name="'+name+'"]').text('')
						}
					}


					if (res.error_fields) {
						for(i in res.error_fields) {
								
							let name = res.error_fields[i]
							
							let fields = [
								form.find('input[name="'+name+'"]'),
								form.find('select[name="'+name+'"]'),
								form.find('textarea[name="'+name+'"]')
							]

							for(i in fields){

								fields[i].parent().addClass('has-error')
							}
						}
					}

					if (res.flash) {

						if ('success' == res.status) {
							
							toastr.success(res.flash)

						} else if('error' == res.status) {

                			toastr.error(res.flash)
						}
					}

					if (res.redirect) {

						setTimeout(function(){
							toastr.info('Mengalihkan...')
						}, 1000)

						setTimeout(function(){
							window.location.href = res.redirect
						}, 2000)
					}
				}
			})
		})
	})

	$('a.xlink').each(function(){
		
		let
			link = $(this),
			url = link.attr('href')

		link.attr('href', 'javascript:void(0)')

		link.off('click').on('click', function () {
		    swal({
		        title: 'Apakah anda yakin?',
		        text: link.attr('message'),
		        type: 'warning',
		        showCancelButton: true,
		        confirmButtonText: 'Ya, Lanjutkan!'
		    }, function () {

		        window.location.href = url
		    })
		})
	})

	$('table.xtable').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            {extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', /*title: 'ExampleFile'*/},
            {extend: 'pdf', /*title: 'ExampleFile'*/},
            {extend: 'print',
             customize: function (win){
                    $(win.document.body).addClass('white-bg')
                    $(win.document.body).css('font-size', '10px')
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit')
            }
            }
        ]
    })

	$.fn.datepicker.dates['id'] = {
		days: [
			'Ahad',
			'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu'
		],
		daysShort: ['Ahd', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		daysMin: ['Ah', 'Sn', 'Sl', 'Ra', 'Ka', 'Ju', 'Sa'],
		months: [
			'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		],
		monthsShort: [
			'Jan',
			'Feb',
			'Mar',
			'Apr',
			'Mei',
			'Jun',
			'Jul',
			'Ags',
			'Sep',
			'Okt',
			'Nov',
			'Des'
		],
		today: 'Hari Ini',
		clear: 'Kosongkan'
	}

    $('input.xdate-decade').datepicker({
        startView: 2,
        todayBtn: 'linked',
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: 'dd/mm/yyyy',
    	language: 'id'
    })
}

Pace.start()
$(function(){
	Pace.stop()
	inspinia()
	aifos()
})