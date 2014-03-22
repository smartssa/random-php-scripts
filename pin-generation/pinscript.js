Event.observe(window, 'load', init, false);

function init() {
	//new PeriodicalExecuter(updateProgress, 1);
	updateProgress();
	updateNotices();
}

function doPins() {
	var url = 'pin-generate.php';
	var pars = Form.serialize('pinform');
	var target = 'pinoutput';
	var pinJax = new Ajax.Updater(target, url, {method: 'post', parameters: pars, asynchronous: true});
}

function updateProgress() {
	var url = 'get-percent.php';
	var pars = '';
	var target = 'progressbar';
	var progJax = new Ajax.PeriodicalUpdater(target, url, {method: 'post', parameters: pars, frequency: 1});
}
function updateNotices() {
	var url = 'get-notices.php';
	var pars = '';
	var target = 'pinnotices';
	var progJax = new Ajax.PeriodicalUpdater(target, url, {method: 'post', parameters: pars, frequency: 5});
}
