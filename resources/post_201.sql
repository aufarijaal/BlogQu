INSERT INTO blogqu.posts (user_id,category_id,title,slug,thumbnail,body,excerpt,status,parent_id,created_at,updated_at) VALUES
	 (5,1,'Create custom screenshot using the combination of Flameshot and ImageMagick','create-custom-screenshot-using-the-combination-of-flameshot-and-imagemagick-9e5cb6da-94d8-3382-8480-92e823d92dde','thumbnails/201/ccdTippH4WsLfoLS7jAy9UtF3mvorod9IFwMqD0y.png','<div>Are you feel <em>bored </em>for having screenshot that has no styling at all?</div><div>What if you need to add annotation to the screenshot?</div><div><br></div><div>Using the combination of <a href="https://flameshot.org/">Flameshot </a>and <a href="https://www.imagemagick.org/">ImageMagick</a>, you can accomplish the task.</div><div><br>In this article, I will show you how you can custom your screenshot. The style I will use is:</div><ul><li>Add <del>9999px</del> 20px white border to each side.</li><li>Add timestamp to the top of the screenshot, overlapping the top border.</li><li>Use a custom font, in this case is Roboto</li></ul><div><br>Steps:</div><ol><li>Create a bash script named ss.sh in terminal, you can type <strong>nano ss.sh </strong>to immediately edit the file and saving it at the end.</li><li>Copy the below code and then press <strong>Ctrl+O</strong> to save and <strong>Ctrl+X </strong>to exit.</li><li>Set the script to executable by running <strong>chmod+x ss.sh</strong></li></ol><div><br></div><div>You can run the script by typing <strong>./ss.sh</strong>, if you want to make this script to be able to run from anywhere without specifying the script path, you can add it to the <strong>PATH</strong>, and you can make this script to be called by a keyboard shortcut</div><div>The <a href="https://gist.github.com/aufarijaal/527208eccb35781a58b861ed2a208365">code</a>:</div><pre>#!/bin/bash

timestamp=$(date +''%Y-%m-%d_%H-%M-%S'')
timestampAnnotation=$(date +''%A, %d %B %Y - %T'')
foldername=$(date +''%Y-%m'')
destination="/path-to-your-folder/$foldername"

if [ ! -d "$destination" ]; then
    mkdir -p "$destination"
fi


screenshot_name="$destination/$timestamp.png"
flameshot gui -p "$screenshot_name"

if [[ "$1" != "--no-edit" ]]; then
    convert "$screenshot_name" \\
    -bordercolor white -border 20x20 \\
    -gravity north -pointsize 12 -font Roboto -fill black -annotate +0+3 "$timestampAnnotation" "$screenshot_name"
fi</pre><div><br></div><div>That''s all.<br><br></div><h1>Sharing is caring</h1>','Are you feel bored for having screenshot that has no styling at all?What if you need to add annotati','published',NULL,'2023-07-23 23:43:45','2023-07-25 07:34:41');
