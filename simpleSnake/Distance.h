#include <iostream>

int Distanza(int x1, int x2) {
    int dis;
    if(x1>x2) {
        dis=x1-x2;
    }
    else
        dis=x2-x1;
    return dis*dis;
}

