<?php

// Disallow direct access to this file for security reasons
if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.");
}

// HOOKS
$plugins->add_hook('build_forumbits_forum', 'randomly_index');


function randomly_info()
{
	return array(
		"name"			=> "Randomly Index - Random Threads auf dem Index",
		"description"	=> "Aus festgelegten Foren einer Kategorie werden zufällige Themen auf dem Index angezeigt. <br /><br />
    Einbindbare Plugins: XThreads, Themenbeschreibung/Thread Desription (von Starpaul20)",
		"website"		=> "https://www.fam-thiessen.net",
		"author"		=> "#rivers @ EPIC [May-Britt Thie&szlig;en]",
		"authorsite"	=> "https://www.fam-thiessen.net",
		"version"		=> "1.0",
		"guid" 			=> "",
		"codename"		=> "",
		"compatibility" => "18*"
	);
}

function randomly_install()
{

  global $db, $cache, $mybb;

// Einstellungen erstellen
  $setting_group = array(
                          'name' => 'randomly',
                          'title' => 'Randomly Index',
                          'description' => 'Einstellungen für Random Threads auf dem Index',
                          'disporder' => 1,
                          'isdefault' => 0
                        );

  $gid = $db->insert_query("settinggroups", $setting_group);

  $setting_array = array(
												'randomly_xthreads' => array(
																							'title' => '[Allgemein] xThreads',
																							'description' => 'Ist das Plugin xThreads installiert?',
																							'optionscode' => 'yesno',
																							'value' => 1, // Default
																							'disporder' => 1
													),
													'randomly_anzahl' => array(
                                              'title' => '[Allgemein] Anzahl der Randoms',
                                              'description' => 'Wie viele verschiedene Random-Inhalte sollen auf dem Index angezeigt werden? (Standard: 1; maximal: 3)',
                                              'optionscode' => 'select\n0=0\n1=1\n2=2\n3=3',
                                              'value' => 1, // Default
                                              'disporder' => 2
                          ),
													'randomly_templates' => array(
																								'title' => '[Allgemein] Verschiedene Templates',
																								'description' => 'Sollen für die verschiedenen Randoms verschiedene Templates genutzt werden?',
																								'optionscode' => 'yesno',
																								'value' => 0, // Default
																								'disporder' => 3
													),


													'randomly_show1' => array(
                                              'title' => '[Random 1] Anzeigekategorie',
                                              'description' => 'Vor welcher Kategorie sollen die Random Threads angezeigt werden?',
                                              'optionscode' => 'forumselectsingle',
                                              'disporder' => 4
                          ),
                          'randomly_forums1' => array(
                                              'title' => '[Random 1] Foren für Random Inhalte',
                                              'description' => 'In welchen Foren befinden sich die Themen, die angezeigt werden sollen? (Mehrfachauswahl möglich!)',
                                              'optionscode' => 'forumselect',
                                              'disporder' => 5
                          ),
                          'randomly_groups1' => array(
                                              'title' => '[Random 1] Anzeige für folgende Gruppen',
                                              'description' => 'Welchen Gruppen sollen die Threads angezeigt werden?',
                                              'optionscode' => 'groupselect',
                                              'disporder' => 6
                          ),
                          'randomly_count1' => array(
                                              'title' => '[Random 1] Anzahl der Threads',
                                              'description' => 'Wie viele Threads sollen auf der Startseite angezeigt werden?',
                                              'optionscode' => 'numeric',
                                              'value' => 2, // Default
                                              'disporder' => 7
                          ),
													'randomly_xpicture1' => array(
                                              'title' => '[Random 1] Key des Bildfeldes (xThreads)',
                                              'description' => 'Welchen Key hat das Feld, in dem das Bild für den Thread eingefügt ist?',
                                              'optionscode' => 'text',
                                              'disporder' => 8
                          ),
                          'randomly_picture1' => array(
                                              'title' => '[Random 1] Ersatzbild',
                                              'description' => 'Welches Bild soll Gästen angezeigt werden oder wenn kein Bild angegeben wurde?',
                                              'optionscode' => 'text',
                                              'disporder' => 9
                          ),
													'randomly_fields1' => array(
																							'title' => "[Random 1] xThread-Felder",
																							'description' => 'Bitte gib hier die <b>Keys</b> der angelegenten Profilefields ein, <b>getrennt durch Komma und Leerstelle</b> (Beispiel: "key1, key2, key3"). <br />
																							Du kannst diese später im Template als Variablen aufrufen, z.B. <b>$key1</b>. Bitte beachte auch die ReadMe!',
																							'optionscode' => 'textarea',
																							'disporder' => 10
													),

													'randomly_show2' => array(
                                              'title' => '[Random 2] Anzeigekategorie',
                                              'description' => 'Vor welcher Kategorie sollen die Random Threads angezeigt werden?',
                                              'optionscode' => 'forumselectsingle',
                                              'disporder' => 11
                          ),
                          'randomly_forums2' => array(
                                              'title' => '[Random 2] Foren für Random Inhalte',
                                              'description' => 'In welchen Foren befinden sich die Themen, die angezeigt werden sollen? (Mehrfachauswahl möglich!)',
                                              'optionscode' => 'forumselect',
                                              'disporder' => 12
                          ),
                          'randomly_groups2' => array(
                                              'title' => '[Random 2] Anzeige für folgende Gruppen',
                                              'description' => 'Welchen Gruppen sollen die Threads angezeigt werden?',
                                              'optionscode' => 'groupselect',
                                              'disporder' => 13
                          ),
                          'randomly_count2' => array(
                                              'title' => '[Random 2] Anzahl der Threads',
                                              'description' => 'Wie viele Threads sollen auf der Startseite angezeigt werden?',
                                              'optionscode' => 'numeric',
                                              'value' => 2, // Default
                                              'disporder' => 14
                          ),
													'randomly_xpicture2' => array(
                                              'title' => '[Random 2] Key des Bildfeldes (xThreads)',
                                              'description' => 'Welchen Key hat das Feld, in dem das Bild für den Thread eingefügt ist?',
                                              'optionscode' => 'text',
                                              'disporder' => 15
                          ),
                          'randomly_picture2' => array(
                                              'title' => '[Random 2] Ersatzbild',
                                              'description' => 'Welches Bild soll Gästen angezeigt werden oder wenn kein Bild angegeben wurde?',
                                              'optionscode' => 'text',
                                              'disporder' => 16
                          ),
													'randomly_fields2' => array(
																							'title' => "[Random 2] xThread-Felder",
																							'description' => 'Bitte gib hier die <b>Keys</b> der angelegenten Profilefields ein, <b>getrennt durch Komma und Leerstelle</b> (Beispiel: "key1, key2, key3"). <br />
																							Du kannst diese später im Template als Variablen aufrufen, z.B. <b>$key1</b>. Bitte beachte auch die ReadMe!',
																							'optionscode' => 'textarea',
																							'disporder' => 17
													),

													'randomly_show3' => array(
                                              'title' => '[Random 3] Anzeigekategorie',
                                              'description' => 'Vor welcher Kategorie sollen die Random Threads angezeigt werden?',
                                              'optionscode' => 'forumselectsingle',
                                              'disporder' => 18
                          ),
                          'randomly_forums3' => array(
                                              'title' => '[Random 3] Foren für Random Inhalte',
                                              'description' => 'In welchen Foren befinden sich die Themen, die angezeigt werden sollen? (Mehrfachauswahl möglich!)',
                                              'optionscode' => 'forumselect',
                                              'disporder' => 19
                          ),
                          'randomly_groups3' => array(
                                              'title' => '[Random 3] Anzeige für folgende Gruppen',
                                              'description' => 'Welchen Gruppen sollen die Threads angezeigt werden?',
                                              'optionscode' => 'groupselect',
                                              'disporder' => 20
                          ),
                          'randomly_count3' => array(
                                              'title' => '[Random 3] Anzahl der Threads',
                                              'description' => 'Wie viele Threads sollen auf der Startseite angezeigt werden?',
                                              'optionscode' => 'numeric',
                                              'value' => 2, // Default
                                              'disporder' => 21
                          ),
                          'randomly_picture3' => array(
                                              'title' => '[Random 3] Ersatzbild',
                                              'description' => 'Welches Bild soll Gästen angezeigt werden oder wenn kein Bild angegeben wurde?',
                                              'optionscode' => 'text',
                                              'disporder' => 22
                          ),
													'randomly_xpicture3' => array(
                                              'title' => '[Random 3] Key des Bildfeldes (xThreads)',
                                              'description' => 'Welchen Key hat das Feld, in dem das Bild für den Thread eingefügt ist?',
                                              'optionscode' => 'text',
                                              'disporder' => 23
                          ),
                          'randomly_picture3' => array(
                                              'title' => '[Random 3] Ersatzbild',
                                              'description' => 'Welches Bild soll Gästen angezeigt werden oder wenn kein Bild angegeben wurde?',
                                              'optionscode' => 'text',
                                              'disporder' => 24
                          ),
													'randomly_fields3' => array(
																							'title' => "[Random 3] xThread-Felder",
																							'description' => 'Bitte gib hier die <b>Keys</b> der angelegenten Profilefields ein, <b>getrennt durch Komma und Leerstelle</b> (Beispiel: "key1, key2, key3"). <br />
																							Du kannst diese später im Template als Variablen aufrufen, z.B. <b>$key1</b>. Bitte beachte auch die ReadMe!',
																							'optionscode' => 'textarea',
																							'disporder' => 25
													)
                      );

  foreach ($setting_array as $name => $setting)
  {
    $setting['name'] = $name;
    $setting['gid']  = $gid;
    $db->insert_query('settings', $setting);
  }
  rebuild_settings();


// Templategruppe und Templates anlegen
  $templategroup = array(
                        'prefix' => 'randomly',
                        'title' => 'Random Threads auf dem Index'
                        );
  $db->insert_query("templategroups", $templategroup);

  $insert_array = array(
                        'title' => 'randomly_single_index',
                        'template' => $db->escape_string('
<div class="roi">
  {$forum[\'roi_bit\']}
</div>
                        '),
                        'sid' => '-2',
                        'dateline' => TIME_NOW
                        );
  $db->insert_query("templates", $insert_array);

  $insert_array = array(
                        'title' => 'randomly_single_bit',
                        'template' => $db->escape_string('
												<div class="roi_box">
												  <div class="roi_img" style="background: url(\'{$roi_image}\'); background-size: cover; background-position: center;" /></div>

												  <div class="roi_inhalt">
												    <div class="roi_title">{$roi_threadtitle}</div>
												    <div class="roi_gesuch">
												      <div>
												        <div class="roi_info">FREIE VARIABLE 1</div>
												        <div class="roi_info">FREIE VARIABLE 2</div>
												        <div class="roi_info">Forum: {$roi_forum}</div>
												      </div>
												      <div class="roi_desc">
												        FREIE BESCHREIBUNGSVARIABLE
														</div>
														gesucht von: {$roi_suchender}

												    </div>
												  </div>
												</div>
                        '),
                        'sid' => '-2',
                        'dateline' => TIME_NOW
                        );
  $db->insert_query("templates", $insert_array);


	$insert_array = array(
                        'title' => 'randomly_v1_index',
                        'template' => $db->escape_string('
<div class="roi">
  {$forum[\'roi_bit\']}
</div>
                        '),
                        'sid' => '-2',
                        'dateline' => TIME_NOW
                        );
  $db->insert_query("templates", $insert_array);

  $insert_array = array(
                        'title' => 'randomly_v1_bit',
                        'template' => $db->escape_string('
												<div class="roi_box">
												  <div class="roi_img" style="background: url(\'{$roi_image}\'); background-size: cover; background-position: center;" /></div>

												  <div class="roi_inhalt">
												    <div class="roi_title">{$roi_threadtitle}</div>
												    <div class="roi_gesuch">
												      <div>
												        <div class="roi_info">FREIE VARIABLE 1</div>
												        <div class="roi_info">FREIE VARIABLE 2</div>
												        <div class="roi_info">Forum: {$roi_forum}</div>
												      </div>
												      <div class="roi_desc">
												        FREIE BESCHREIBUNGSVARIABLE
														</div>
														gesucht von: {$roi_suchender}

												    </div>
												  </div>
												</div>
                        '),
                        'sid' => '-2',
                        'dateline' => TIME_NOW
                        );
  $db->insert_query("templates", $insert_array);

	$insert_array = array(
                        'title' => 'randomly_v2_index',
                        'template' => $db->escape_string('
<div class="roi">
  {$forum[\'roi_bit\']}
</div>
                        '),
                        'sid' => '-2',
                        'dateline' => TIME_NOW
                        );
  $db->insert_query("templates", $insert_array);

  $insert_array = array(
                        'title' => 'randomly_v2_bit',
                        'template' => $db->escape_string('
												<div class="roi_box">
												  <div class="roi_img" style="background: url(\'{$roi_image}\'); background-size: cover; background-position: center;" /></div>

												  <div class="roi_inhalt">
												    <div class="roi_title">{$roi_threadtitle}</div>
												    <div class="roi_gesuch">
												      <div>
												        <div class="roi_info">FREIE VARIABLE 1</div>
												        <div class="roi_info">FREIE VARIABLE 2</div>
												        <div class="roi_info">Forum: {$roi_forum}</div>
												      </div>
												      <div class="roi_desc">
												        FREIE BESCHREIBUNGSVARIABLE
														</div>
														gesucht von: {$roi_suchender}

												    </div>
												  </div>
												</div>
                        '),
                        'sid' => '-2',
                        'dateline' => TIME_NOW
                        );
  $db->insert_query("templates", $insert_array);


	$insert_array = array(
                        'title' => 'randomly_v3_index',
                        'template' => $db->escape_string('
<div class="roi">
  {$forum[\'roi_bit\']}
</div>
                        '),
                        'sid' => '-2',
                        'dateline' => TIME_NOW
                        );
  $db->insert_query("templates", $insert_array);

  $insert_array = array(
                        'title' => 'randomly_v3_bit',
                        'template' => $db->escape_string('
												<div class="roi_box">
												  <div class="roi_img" style="background: url(\'{$roi_image}\'); background-size: cover; background-position: center;" /></div>

												  <div class="roi_inhalt">
												    <div class="roi_title">{$roi_threadtitle}</div>
												    <div class="roi_gesuch">
												      <div>
												        <div class="roi_info">FREIE VARIABLE 1</div>
												        <div class="roi_info">FREIE VARIABLE 2</div>
												        <div class="roi_info">Forum: {$roi_forum}</div>
												      </div>
												      <div class="roi_desc">
												        FREIE BESCHREIBUNG
														</div>
														gesucht von: {$roi_suchender} 

												    </div>
												  </div>
												</div>
                        '),
                        'sid' => '-2',
                        'dateline' => TIME_NOW
                        );
  $db->insert_query("templates", $insert_array);



// CSS
	$css = array(
							'name' => 'randomindex.css',
							'tid' => 1,
							'stylesheet' => '.roi {
  width: 100%;
  background: none;
  border: 0;
  display: flex;
  justify-content: space-between;
}

.roi_box {
  width: 49%;
  box-sizing: border-box;
  padding: 15px;
  background-color: #ccc;
  display: flex;
  gap: 2%;
}

.roi_img {
  width: 28%;
  height: 150px;
  background-color: #eee;
}

.roi_inhalt {
  width: 70%;
  background: #fff;
}

.roi_title {
  font-weight: bold;
  text-transform: uppercase;
  height: 25px;
  margin: 0;
}

.roi_gesuch {
  display: flex;
  gap: 10px;
  justify-content: space-between;
  height: 125px;
}

.roi_info {
  width: 150px;
  background: #efefef;
  margin: 2px 0;
  padding: 2px;
  text-align: center;
}

.roi_desc {
  position: relative;
  height: 125px;
}

.roi_desc:after {
  content: attr(data-title);
  position: absolute;
  right: 0;
  bottom: 0px;
  font-size: 10px;
}',
							'cachefile' => $db->escape_string(str_replace('/', '', "randomindex.css")),
							'lastmodified' => time()
						);

	require_once MYBB_ADMIN_DIR."inc/functions_themes.php";

	$sid = $db->insert_query("themestylesheets", $css);
	$db->update_query("themestylesheets", array("cachefile" => "css.php?stylesheet=".$sid), "sid = '".$sid."'", 1);

	$tids = $db->simple_select("themes", "tid");
	while($theme = $db->fetch_array($tids)) {
		update_theme_stylesheet_list($theme['tid']);
	}


}

function randomly_is_installed()
{
  global $mybb;

  if ($mybb->settings['randomly_xthreads'])
  {
    return true;
  }
  return false;
}

function randomly_uninstall()
{
  global $db;

  $db->delete_query('settings', "name LIKE 'randomly_%'");
  $db->delete_query('settinggroups', "name = 'randomly'");
  $db->delete_query("templates", "title LIKE 'randomly_%'");
  $db->delete_query("templategroups", "prefix = 'randomly'");

  rebuild_settings();
}


function randomly_activate()
{
  global $db, $cache;

  require MYBB_ROOT."/inc/adminfunctions_templates.php";

  find_replace_templatesets(	'forumbit_depth1_cat',
															'#'.preg_quote('<table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">').'#',
															'{$forum[\'randomly_index\']} {$forum[\'randomly_index2\']} {$forum[\'randomly_index3\']} <table border="0" cellspacing="{$theme[\'borderwidth\']}" cellpadding="{$theme[\'tablespace\']}" class="tborder">'
														);
}


function randomly_deactivate()
{
  global $db, $cache;

  require MYBB_ROOT."/inc/adminfunctions_templates.php";

  find_replace_templatesets("forumbit_depth1_cat", "#".preg_quote('{$forum[\'randomly_index\']} {$forum[\'randomly_index2\']} {$forum[\'randomly_index3\']} ')."#i", '', 0);
}



// Let the magic BEGIN

function randomly_index(&$forum)
{
  global $mybb, $db, $templates;

	// Allgemeine Settings auslesen:
	$randomly_xthreads = $mybb->settings['randomly_xthreads'];
	$randomly_anzahl = $mybb->settings['randomly_anzahl'];
	$randomly_templates = $mybb->settings['randomly_templates'];

	// Settings für Random1:
	$randomly_show1 = $mybb->settings['randomly_show1']; // Anzeigekategorie
	$randomly_forums1 = $mybb->settings['randomly_forums1']; // Forums, aus denen random Threads angezeigt werden Sollen
	$randomly_groups1 = $mybb->settings['randomly_groups1']; // Welche Usergruppen sollen es sehen können?
	$randomly_count1 = $mybb->settings['randomly_count1']; // Wie viele Randoms sollen angezeigt werden?
	$randomly_xpicture1 = $mybb->settings['randomly_xpicture1']; // Key des Feldes für das Bild in xThreads
	$random_picture1 = $mybb->settings['randomly_picture1']; // Ersatzbild für leere Bilder
	$randomly_fields1 = $mybb->settings['randomly_fields1']; // Keys der Profilfelder

	// Settings für Random2:
	$randomly_show2 = $mybb->settings['randomly_show2']; // Anzeigekategorie
	$randomly_forums2 = $mybb->settings['randomly_forums2']; // Forums, aus denen random Threads angezeigt werden Sollen
	$randomly_groups2 = $mybb->settings['randomly_groups2']; // Welche Usergruppen sollen es sehen können?
	$randomly_count2 = $mybb->settings['randomly_count2']; // Wie viele Randoms sollen angezeigt werden?
	$randomly_xpicture2 = $mybb->settings['randomly_xpicture2']; // Key des Feldes für das Bild in xThreads
	$random_picture2 = $mybb->settings['randomly_picture2']; // Ersatzbild für leere Bilder
	$randomly_fields2 = $mybb->settings['randomly_fields2']; // Keys der Profilfelder

	// Settings für Random3:
	$randomly_show3 = $mybb->settings['randomly_show3']; // Anzeigekategorie
	$randomly_forums3 = $mybb->settings['randomly_forums3']; // Forums, aus denen random Threads angezeigt werden Sollen
	$randomly_groups3 = $mybb->settings['randomly_groups3']; // Welche Usergruppen sollen es sehen können?
	$randomly_count3 = $mybb->settings['randomly_count3']; // Wie viele Randoms sollen angezeigt werden?
	$randomly_xpicture3 = $mybb->settings['randomly_xpicture3']; // Key des Feldes für das Bild in xThreads
	$random_picture3 = $mybb->settings['randomly_picture3']; // Ersatzbild für leere Bilder
	$randomly_fields3 = $mybb->settings['randomly_fields3']; // Keys der Profilfelder

	// Allgemeine Variablen:
	$match_usergroup = "/\b".$mybb->user['usergroup']."\b/";

	// vorab leeren der Ausgabevariablen:
	$forum['randomly_index'] = $forum['randomly_index2'] = $forum['randomly_index3'] = "";

	// Bedingungen für Nicht-Ausgabe
	if ($randomly_anzahl == '1' && $forum['fid'] != $randomly_show1)
	{
		return;
	}
	elseif ($random_anzahl == '2' && ($forum['fid'] != $randomly_show1 && $forum['fid'] != $randomly_show2))
	{
		return;
	}
	elseif ($random_anzahl == '3' && ($forum['fid'] != $randomly_show1 && $forum['fid'] != $randomly_show2 && $forum['fid'] != $randomly_show3))
	{
		return;
	}


	/// Nun folgenden die einzelnen Ausgaben.
	// 1. Kategorie
	// Ausgaben wenn Anzahl 1 oder mehr UND aktuelle ForenID ist die AnzeigeID und Usergruppe darf sehen
	if ($randomly_anzahl >= '1' && $forum['fid'] == $randomly_show1 && (preg_match($match_usergroup, $randomly_groups1) == "1" || $randomly_groups1 == "-1"))
	{

		// Query - mit oder ohne xThreads
		// Wir brauchen: Daten des Threads, Userdaten, ggf. xThreads
		if ($randomly_xthreads == '0') // ohne xThreads
		{
			$randomly_query1 = $db->query("	SELECT *
																			FROM ".TABLE_PREFIX."threads t
																			LEFT JOIN ".TABLE_PREFIX."users u
																			ON u.uid = t.uid
																			LEFT JOIN ".TABLE_PREFIX."forums f
																			ON f.fid = t.fid
																			WHERE t.fid IN ($randomly_forums1)
																			ORDER BY RAND()
																			LIMIT ".$randomly_count1."
																		");
		}
		else {
			$randomly_query1 = $db->query("	SELECT *
																			FROM ".TABLE_PREFIX."threads t
																			LEFT JOIN ".TABLE_PREFIX."users u
																			ON u.uid = t.uid
																			LEFT JOIN ".TABLE_PREFIX."forums f
																			ON f.fid = t.fid
																			LEFT JOIN ".TABLE_PREFIX."threadfields_data td
																			ON td.tid = t.tid
																			WHERE t.fid IN ($randomly_forums1)
																			ORDER BY RAND()
																			LIMIT ".$randomly_count1."
																		");
		}

		// $roi_bit leeren
		$forum['roi_bit']  = "";


		// Die Keys als variable Variablen.
		$randomly_fields1_ex = explode(", ", $randomly_fields1);
		$count1 = count($randomly_fields1_ex);

		// Schleife zum Auslesen
		while ($randomly1 = $db->fetch_array($randomly_query1))
		{
			// Bild
			// Wenn kein xThreads verwendet wird ODER kein Bildfeld vorhanden ist ODER ein Gast es betrachtet, dann das Ersatzbild
			if ($randomly_xthreads == '0' || $randomly_xpicture1 == '' || !$mybb->user['uid'] || $mybb->user['uid'] == '0')
			{
				$roi_image = $randomly_picture1;
			}
			// ansonsten ist das Bild das in dem xThread-Feld
			else {
				$roi_image = $randomly1[$randomly_xpicture1];
			}

			// Suchender User
			$roi_suchender = build_profile_link($randomly1['username'], $randomly1['uid']);

			// Forumlink
			$roi_forum = "<a href=\"forumdisplay.php?fid=".$randomly1['fid']."\">".$randomly1['name']."</a>";

			// Thementitel:
			$roi_threadtitle = "<a href=\"showthread.php?tid=".$randomly1['tid']."\">".$randomly1['subject']."</a>";

			// Füllen der variablen Variablen
			for ($i = 0; $i < $count1; $i++)
			{
				$rand = $randomly_fields1_ex[$i];
				$$rand = $randomly1[$rand];
			}


			// Ausgabe der Daten - abhängig
			if ($randomly_templates == '0')
			{
				eval("\$forum['roi_bit'] .= \"".$templates->get('randomly_single_bit')."\";");
			}
			else {
				eval("\$forum['roi_bit'] .= \"".$templates->get('randomly_v1_bit')."\";");
			}

		}

		// Wenn nur ein Template für alles:
		if ($randomly_templates == '0')
		{
			eval("\$forum['randomly_index'] = \"".$templates->get('randomly_single_index')."\";");
		}
		// Oder doch für jede Kategorie ein eigenes Template? Dann dieses!
		else {
			eval("\$forum['randomly_index'] = \"".$templates->get('randomly_v1_index')."\";");
		}

	}

	// 2. Kategorie
	// Ausgaben wenn Anzahl 1 oder mehr UND aktuelle ForenID ist die AnzeigeID und Usergruppe darf sehen
	if ($randomly_anzahl >= '2' && $forum['fid'] == $randomly_show2 && (preg_match($match_usergroup, $randomly_groups2) == "1" || $randomly_groups2 == "-1"))
	{
		// Query - mit oder ohne xThreads
		// Wir brauchen: Daten des Threads, Userdaten, ggf. xThreads
		if ($randomly_xthreads == '0') // ohne xThreads
		{
			$randomly_query2 = $db->query("	SELECT *
																			FROM ".TABLE_PREFIX."threads t
																			LEFT JOIN ".TABLE_PREFIX."users u
																			ON u.uid = t.uid
																			LEFT JOIN ".TABLE_PREFIX."forums f
																			ON f.fid = t.fid
																			WHERE t.fid IN ($randomly_forums2)
																			ORDER BY RAND()
																			LIMIT ".$randomly_count2."
																		");
		}
		else {
			$randomly_query2 = $db->query("	SELECT *
																			FROM ".TABLE_PREFIX."threads t
																			LEFT JOIN ".TABLE_PREFIX."users u
																			ON u.uid = t.uid
																			LEFT JOIN ".TABLE_PREFIX."forums f
																			ON f.fid = t.fid
																			LEFT JOIN ".TABLE_PREFIX."threadfields_data td
																			ON td.tid = t.tid
																			WHERE t.fid IN ($randomly_forums2)
																			ORDER BY RAND()
																			LIMIT ".$randomly_count2."
																		");
		}

		// $roi_bit leeren
		$forum['roi_bit']  = "";

		// Schleife zum Auslesen
		while ($randomly2 = $db->fetch_array($randomly_query2))
		{
			// Bild
			// Wenn kein xThreads verwendet wird ODER kein Bildfeld vorhanden ist ODER ein Gast es betrachtet, dann das Ersatzbild
			if ($randomly_xthreads == '0' || $randomly_xpicture2 == '' || !$mybb->user['uid'] || $mybb->user['uid'] == '0')
			{
				$roi_image = $randomly_picture2;
			}
			// ansonsten ist das Bild das in dem xThread-Feld
			else {
				$roi_image = $randomly2[$randomly_xpicture2];
			}

			// Suchender User
			$roi_suchender = build_profile_link($randomly2['username'], $randomly2['uid']);

			// Forumlink
			$roi_forum = "<a href=\"forumdisplay.php?fid=".$randomly2['fid']."\">".$randomly2['name']."</a>";


			// Thementitel:
			$roi_threadtitle = "<a href=\"showthread.php?tid=".$randomly2['tid']."\">".$randomly2['subject']."</a>";

			// Ausgabe der Daten - abhängig
			if ($randomly_templates == '0')
			{
				eval("\$forum['roi_bit'] .= \"".$templates->get('randomly_single_bit')."\";");
			}
			else {
				eval("\$forum['roi_bit'] .= \"".$templates->get('randomly_v2_bit')."\";");
			}

		}

		// Wenn nur ein Template für alles:
		if ($randomly_templates == '0')
		{
			eval("\$forum['randomly_index2'] = \"".$templates->get('randomly_single_index')."\";");
		}
		// Oder doch für jede Kategorie ein eigenes Template? Dann dieses!
		else {
			eval("\$forum['randomly_index2'] = \"".$templates->get('randomly_v2_index')."\";");
		}

	}

	// 3. Kategorie
	// Ausgaben wenn Anzahl 1 oder mehr UND aktuelle ForenID ist die AnzeigeID und Usergruppe darf sehen
	if ($randomly_anzahl >= '3' && $forum['fid'] == $randomly_show3 && (preg_match($match_usergroup, $randomly_groups3) == "1" || $randomly_groups3 == "-1"))
	{
		// Query - mit oder ohne xThreads
		// Wir brauchen: Daten des Threads, Userdaten, ggf. xThreads
		if ($randomly_xthreads == '0') // ohne xThreads
		{
			$randomly_query3 = $db->query("	SELECT *
																			FROM ".TABLE_PREFIX."threads t
																			LEFT JOIN ".TABLE_PREFIX."users u
																			ON u.uid = t.uid
																			LEFT JOIN ".TABLE_PREFIX."forums f
																			ON f.fid = t.fid
																			WHERE t.fid IN ($randomly_forums3)
																			ORDER BY RAND()
																			LIMIT ".$randomly_count3."
																		");
		}
		else {
			$randomly_query3 = $db->query("	SELECT *
																			FROM ".TABLE_PREFIX."threads t
																			LEFT JOIN ".TABLE_PREFIX."users u
																			ON u.uid = t.uid
																			LEFT JOIN ".TABLE_PREFIX."forums f
																			ON f.fid = t.fid
																			LEFT JOIN ".TABLE_PREFIX."threadfields_data td
																			ON td.tid = t.tid
																			WHERE t.fid IN ($randomly_forums3)
																			ORDER BY RAND()
																			LIMIT ".$randomly_count3."
																		");
		}

		// $roi_bit leeren
		$forum['roi_bit']  = "";

		// Schleife zum Auslesen
		while ($randomly3 = $db->fetch_array($randomly_query3))
		{
			// Bild
			// Wenn kein xThreads verwendet wird ODER kein Bildfeld vorhanden ist ODER ein Gast es betrachtet, dann das Ersatzbild
			if ($randomly_xthreads == '0' || $randomly_xpicture3 == '' || !$mybb->user['uid'] || $mybb->user['uid'] == '0')
			{
				$roi_image = $randomly_picture3;
			}
			// ansonsten ist das Bild das in dem xThread-Feld
			else {
				$roi_image = $randomly3[$randomly_xpicture2];
			}

			// Suchender User
			$roi_suchender = build_profile_link($randomly3['username'], $randomly3['uid']);

			// Forumlink
			$roi_forum = "<a href=\"forumdisplay.php?fid=".$randomly3['fid']."\">".$randomly3['name']."</a>";


			// Thementitel:
			$roi_threadtitle = "<a href=\"showthread.php?tid=".$randomly3['tid']."\">".$randomly3['subject']."</a>";

			// Ausgabe der Daten - abhängig
			if ($randomly_templates == '0')
			{
				eval("\$forum['roi_bit'] .= \"".$templates->get('randomly_single_bit')."\";");
			}
			else {
				eval("\$forum['roi_bit'] .= \"".$templates->get('randomly_v3_bit')."\";");
			}

		}

		// Wenn nur ein Template für alles:
		if ($randomly_templates == '0')
		{
			eval("\$forum['randomly_index3'] = \"".$templates->get('randomly_single_index')."\";");
		}
		// Oder doch für jede Kategorie ein eigenes Template? Dann dieses!
		else {
			eval("\$forum['randomly_index3'] = \"".$templates->get('randomly_v3_index')."\";");
		}
	}

}
