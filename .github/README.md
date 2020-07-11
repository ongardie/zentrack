# ZenTrack issue tracker

This is an unofficial import of the ZenTrack Subversion repository located at
<https://sourceforge.net/p/zentrack/code/HEAD/tree/zentrack-2/> and the
ZenTrack CVS repository located at <http://zentrack.cvs.sourceforge.net/>. As
of this writing in 2020, the last update to the project was in 2009 or 2010.

This README describes this GitHub mirror of the ZenTrack code. The top-level
[README.txt](../README.txt) file describes the upstream project. The project's
former website is available through the Internet Archive at
<https://web.archive.org/web/20121026100727/http://www.zentrack.net:80/>.

[ZenTrack](https://sourceforge.net/projects/zentrack/) is a defunct issue
tracking system written in PHP for the
[LAMP stack](https://en.wikipedia.org/wiki/LAMP_(software_bundle)).

This mirror exists as a historical archive only. As the project page on
Sourceforge states, "this project is no longer maintained or active".

I (Diego) have a minor interest in keeping a copy of the code base available
online since I worked on it early in my career.

This mirror was created following these steps:

1. Import the Subversion repository at
   <https://svn.code.sf.net/p/zentrack/code/zentrack-2> using the GitHub UI.

2. Rename the default branch to `trunk`.

3. Download the CVS repository (since the Subversion history only starts
   around version 2.7):
   ```sh
   rsync -ai a.cvs.sourceforge.net::cvsroot/zentrack/ zentrack.cvs
   ```

4. Import the CVS repository into two new Git repos:
   ```sh
   mkdir cvsimport-zentrack_2
   cd cvsimport-zentrack_2
   git cvsimport -d $(pwd)/../zentrack.cvs zentrack_2
   cd ..
   mkdir cvsimport-zentrack
   cd cvsimport-zentrack
   git cvsimport -d $(pwd)/../zentrack.cvs zentrack
   ```

5. Fetch from those into a clone of GitHub's Subversion import, and push
   everything up.

6. Add this README.
