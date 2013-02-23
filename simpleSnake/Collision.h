#include <iostream>
#include "Distance.h"

bool Collision(int x1, int x2, int y1, int y2, int radius, int radius1) {
    int diam=radius+radius1;
    if(Distanza(x1, x2)+Distanza(y1,y2)<(diam*diam))
        return true;
    else
        return false;
}
