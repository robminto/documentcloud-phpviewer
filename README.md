# documentcloud-phpviewer
A php script to pull data from DocumentCloud's API, and serve into a template with PDF viewer

Initially, this was used for a project called Unredacted UK - https://unredacted.uk 

It is a re-write in PHP of this:
https://github.com/jkeefe/Custom-Viewer-for-DocumentCloud

In 2020, when DocumentCloud moved into beta, John Keefe's Jquery script stopped working - well, it stopped for new upload files as there was a new URL structure and new API.

So I wrote a new version in PHP. It simplifies things a LOT, as rather than several .js files it uses just one PHP script and one CSS.
- dcviewer_blank.php - feel free to drop the blank.
- docviewer.css - you can put this in a relative file structure if you need.

The coding isn't perfect - I'm a journalist-coder rather than a coder-coder, but you are free to improve etc.

The basis of the script is to set your own URL and Organistaion name. Then the script uses an ID in the URL to pull the json file from the DocumentCloud API. The json can then be parsed into variables which are dropped into the template. 

The canonical_url attribute is then used to pull the document in via an iFrame.

That's basically it. There are comments in the PHP script to help, but for anyone with a bit of PHP knowledge it should be clear what's going on.

If you use it, change it, improve it - please let us know.

Thanks
