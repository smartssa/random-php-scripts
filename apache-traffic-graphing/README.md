Here's some old samples of making graphcs on the fly with jpgraph.

Made this some time in 2004, it's not very exciting, but here's the "bad idea":

1. configure apache to log to mysql (a REALLY bad idea)
2. pull hit counts on the fly and generate graphs on the fly
3. serve it up.

Ironically, the hits to the graphs would inflate the apache logs and make
the graphs even better.

-d
