const
	{series} = require("gulp"),
	bump = require("./gulp_modules/task-bump"),
	replace_version = require("./gulp_modules/task-replace-version"),
	pot = series(replace_version, require("./gulp_modules/task-pot")),
	pomo = series(pot, require("./gulp_modules/task-tivwp_pomo")),
	dist = series( pomo)
;

exports.bump = bump;
exports.replace_version = replace_version;
exports.pot = pot;
exports.pomo = pomo;
exports.dist = dist;
exports.default = exports.dist;

